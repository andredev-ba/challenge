<?php
namespace App\Repositories\Eloquent;

use Core\Domain\Category\Repository\CategoryRepositoryInterface;
use Core\Domain\Shared\Repository\PaginationInterface;
use App\Repositories\Presenters\{
    PaginationPresenter,
    CategoryPresenter
};
use Core\Domain\Shared\Exception\{
    RepositoryException,
    NotFoundException
};
use App\Models\Category as Model;
use Core\Domain\Category\Entity\CategoryEntity;
use Core\Domain\Shared\ValueObject\Uuid;


class CategoryEloquentRepository implements CategoryRepositoryInterface
{
    public function __construct(
        protected Model $model
    ){}

    public function paginate(array $filters): PaginationInterface {
        $result = $this->model->where(function ($q) use ($filters) {
            if (!empty($filters['search'])) {
                $q->where('name', 'like', "%{$filters['search']}%");
            }
        })->orderBy($filters['sortBy'], $filters['order'])->paginate($filters['rowsPerPage']);

        return new PaginationPresenter($result);
    }

    public function findAll(): CategoryPresenter {
        $result = $this->model->get();
        return new CategoryPresenter($result);
    }

    public function findById(string $categoryId): CategoryEntity
    {
        if (!$categoryModel = $this->model->find($categoryId)) {
            throw new NotFoundException('Category Not Found');
        }

        return $this->toEntity($categoryModel);
    }

    public function insert(CategoryEntity $category): void {
        $inserted = $this->model->create([
            'id' => $category->id(),
            'name' => $category->name,
        ]);

        if(!$inserted) {
            throw new RepositoryException('Insert category error');
        }
    }

    public function update(CategoryEntity $category): void {
        $categoryModel = $this->model->find($category->id());
        $updated = $categoryModel->update([
            'name' => $category->name,
        ]);

        if(!$updated) {
            throw new RepositoryException('Update category error');
        }
    }

    public function delete(string $categoryId): bool
    {
        if (!$categoryModel = $this->model->find($categoryId)) {
            throw new NotFoundException('Category Not Found');
        }

        return $categoryModel->delete();
    }

    private function toEntity(object $categoryModel): CategoryEntity
    {
        return new CategoryEntity(
            id: new Uuid($categoryModel->id),
            name: $categoryModel->name
        );
    }

}