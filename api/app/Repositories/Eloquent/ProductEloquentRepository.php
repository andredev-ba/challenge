<?php
namespace App\Repositories\Eloquent;

use Core\Domain\Product\Repository\ProductRepositoryInterface;
use Core\Domain\Shared\Repository\PaginationInterface;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Shared\Exception\{
    RepositoryException,
    NotFoundException
};
use App\Models\Product as Model;
use Core\Domain\Product\Entity\ProductEntity;
use DateTime;
use Core\Domain\Shared\ValueObject\Uuid;

class ProductEloquentRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected Model $model
    ){}

    public function paginate(array $filters): PaginationInterface {
        $result = $this->model->with('category')->where(function ($q) use ($filters) {
            if (!empty($filters['search'])) {
                $q->where('name', 'like', "%{$filters['search']}%");
                $q->orWhere('description', 'like', "%{$filters['search']}%");
            }
        })->orderBy($filters['sortBy'], $filters['order'])->paginate($filters['rowsPerPage']);

        return new PaginationPresenter($result);
    }

    public function findById(string $productId): ProductEntity
    {
        $productModel = $this->model->find($productId);

        if (!$productModel) {
            throw new NotFoundException('Product Not Found');
        }

        return $this->toEntity($productModel);
    }

    public function insert(ProductEntity $product): void {
        $inserted = $this->model->create([
            'id' => $product->id(),
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'expiration_date' => $product->expirationDate,
            'image_url' => $product->imageUrl,
            'category_id' => $product->categoryId
        ]);

        if(!$inserted) {
            throw new RepositoryException('Insert product error');
        }
    }

    public function update(ProductEntity $product): void {
        $productModel = $this->model->find($product->id());
        $updated = $productModel->update([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'expiration_date' => $product->expirationDate,
            'image_url' => $product->imageUrl,
            'category_id' => $product->categoryId
        ]);

        if(!$updated) {
            throw new RepositoryException('Update product error');
        }
    }

    public function delete(string $productId): bool
    {
        if (!$productModel = $this->model->find($productId)) {
            throw new NotFoundException('Product Not Found');
        }

        return $productModel->delete();
    }

    private function toEntity(object $productModel): ProductEntity
    {
        return new ProductEntity(
            id: new Uuid($productModel->id),
            name: $productModel->name,
            description: $productModel->description,
            price: $productModel->price,
            expirationDate: new DateTime($productModel->expiration_date),
            imageUrl: $productModel->image_url,
            categoryId: $productModel->category_id ? new Uuid($productModel->category_id) : null
        );
    }

}
