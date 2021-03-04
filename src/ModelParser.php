<?php


namespace Tray2\SimpleCrud;


class ModelParser
{
    protected $model;
    protected $display;
    protected $noDisplay = [];
    protected $connectionName;
    protected $guardedByDefault = [
      'id',
      'created_at',
      'updated_at',
      'deleted_at'
    ];

    public function __construct($model)
    {
        $modelPath = "App\Models\\{$model}";
        $this->model = app($modelPath);
        $this->populateNoDisplay();
        $this->populateDisplay();
        $this->connectionName = $this->model->getConnectionName();
    }

    public function getNoDisplayItems(): array
    {
        return $this->noDisplay;
    }

    public function getDisplayItems()
    {
        return $this->display;
    }

    public function getConnectionName()
    {
        return $this->connectionName;
    }

    private function populateNoDisplay()
    {
        $this->noDisplay = array_merge(
            $this->guardedByDefault,
            $this->model->getGuarded(),
            $this->model->getHidden()
        );
    }

    private function populateDisplay()
    {
        $this->display = $this->model->getFillable();
    }
}
