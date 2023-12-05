<?php

namespace App\Repositories\Presenters;

use Core\Domain\Category\Presenter\CategoryPresenterInterface;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class CategoryPresenter implements CategoryPresenterInterface
{
    /**
     * @return stdClass[]
     */
    protected array $items = [];

    public function __construct(
        protected Collection $collection
    ) {
        $this->items = $this->resolveItems(
            items: $collection->toArray()
        );
    }

    /**
     * @return stdClass[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function toQuasarFormSelect(): array
    {
        $response = [];
        foreach ($this->items as $item) {
            $stdClass = new stdClass;
            $stdClass->label = $item->name;
            $stdClass->value = $item->id;
            array_push($response, $stdClass);
        }

        return $response;
    }

    private function resolveItems(array $items): array
    {
        $response = [];

        foreach ($items as $key => $value) {
            array_push($response, (object) $value);
        }

        return $response;
    }

}
