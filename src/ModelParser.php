<?php
namespace Tray2\SimpleCrud;

use ReflectionClass;

class ModelParser
{
    protected $relationships = [
        'Illuminate\Database\Eloquent\Relations\BelongsToMany' => 'belongsToMany',
        'Illuminate\Database\Eloquent\Relations\BelongsTo' => 'belongsTo',
        'Illuminate\Database\Eloquent\Relations\HasOne' => 'hasOne',
        'Illuminate\Database\Eloquent\Relations\HasMany' => 'hasMany',
        'Illuminate\Database\Eloquent\Relations\HasOneThrough' => 'hasOneThrough',
        'Illuminate\Database\Eloquent\Relations\HasManyThrough' => 'hasManyThrough',
        'Illuminate\Database\Eloquent\Relations\MorphOne' => 'morphOne',
        'Illuminate\Database\Eloquent\Relations\MorphTo' => 'morphTo',
        'Illuminate\Database\Eloquent\Relations\MorphMany' => 'morphMany',
        'Illuminate\Database\Eloquent\Relations\MorphToMany' => 'morphToMany',
        'Illuminate\Database\Eloquent\Relations\MorphedByMany' => 'morphedByMany',
    ];
    protected $namespace;
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

    public function __construct($model, $namespace = 'App\Models\\')
    {
        $this->namespace = $namespace;
        $this->model = app($namespace . $model);
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

    public function getRelationships(): array
    {
        $relations = [];
        $reflect = new ReflectionClass($this->model);

        foreach ($reflect->getMethods() as $method) {

            $returnType = $method->getReturnType();

            if (! is_null($returnType)) {

                $relationType = $method->getReturnType()->getName();
                if ($this->isValidRelation($relationType)) {
                    $relations[$method->getName()] =  $this->relationships[$relationType];
                }
            }
        }

        return $relations;
    }

    private function isValidRelation($relationType): bool
    {
        return array_key_exists($relationType, $this->relationships);
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
