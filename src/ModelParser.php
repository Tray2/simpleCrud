<?php /** @noinspection PhpPureAttributeCanBeAddedInspection */

namespace Tray2\SimpleCrud;

use ReflectionClass;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use ReflectionException;

class ModelParser
{
    protected array $relationships = [
        BelongsToMany::class => 'belongsToMany',
        BelongsTo::class => 'belongsTo',
        HasOne::class => 'hasOne',
        HasMany::class => 'hasMany',
        HasOneThrough::class => 'hasOneThrough',
        HasManyThrough::class => 'hasManyThrough',
        MorphOne::class => 'morphOne',
        MorphTo::class => 'morphTo',
        MorphMany::class => 'morphMany',
        MorphToMany::class => 'morphToMany',
        'Illuminate\Database\Eloquent\Relations\MorphedByMany' => 'morphedByMany',
    ];
    protected string $namespace;
    protected $model;
    protected array $display;
    protected array $noDisplay = [];
    protected $connectionName;
    protected array $guardedByDefault = [
      'id',
      'created_at',
      'updated_at',
      'deleted_at'
    ];

    public function __construct($model, $namespace = 'App\Models')
    {
        if ($namespace === '') {
            $namespace = 'App\Models';
        }
        $this->namespace = $namespace . '\\';
        $this->model = app($this->namespace . $model);
        $this->populateNoDisplay();
        $this->populateDisplay();
        $this->connectionName = $this->model->getConnectionName();
    }

    public function getNoDisplayItems(): array
    {
        return $this->noDisplay;
    }

    public function getDisplayItems(): array
    {
        return $this->display;
    }

    public function getConnectionName()
    {
        return $this->connectionName;
    }

    /** @noinspection PhpPossiblePolymorphicInvocationInspection
     * @noinspection NullPointerExceptionInspection
     */
    public function getRelationships(): array
    {
        $relations = [];
        try {
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
        } catch (ReflectionException) {
        }

        return $relations;
    }

    private function isValidRelation($relationType): bool
    {
        return array_key_exists($relationType, $this->relationships);
    }

    private function populateNoDisplay(): void
    {
        $this->noDisplay = array_merge(
            $this->guardedByDefault,
            $this->model->getGuarded(),
            $this->model->getHidden()
        );
    }

    private function populateDisplay(): void
    {
        $this->display = $this->model->getFillable();
    }
}
