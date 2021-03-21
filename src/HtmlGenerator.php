<?php /** @noinspection PhpPureAttributeCanBeAddedInspection */


namespace Tray2\SimpleCrud;


use Illuminate\Support\Str;

class HtmlGenerator
{
    protected string $model;
    protected string $placeHolder = '';
    protected string $required = '';


    public function __construct($model)
    {
        $this->model = $model;
    }

    public function generateLabel(string $element): string
    {
        return "\t" . '<label for="' . $element . '"></label>' . "\n";
    }

    public function generate(array $parameter): string
    {
        $dataTypeTranslator = new DataTypeTranslator();
        $dataType = $dataTypeTranslator->getDataType($parameter['field'], $parameter['type']);
        $this->setRequired($parameter['required']);
        $this->setPlaceholder($parameter['default']);

        $html = $this->generateInput($parameter['field'], $dataType);
        $html .= $this->generateTextArea($parameter['field'], $dataType);
        $html .= $this->generateSelect($parameter['field'], $dataType);
        return $html;
    }

    protected function setRequired($required): void
    {
        if ($required === 'YES') {
            $this->required = 'required';
        }
    }

    protected function setPlaceholder($default): void
    {
        if ($default !== '') {
            $this->placeHolder =  'placeholder="' . $default . '"';
        }
    }

    protected function generateInput($field, string $dataType): string
    {
        if ($dataType !== 'textarea' && $dataType !== 'select') {
            return '<input type="' . $dataType . '" name="' . $field
                . '" id="' . $field
                . '" value="{{ old(\'' . $field
                . '\') }}"'
                . $this->getPlaceHolder()
                . $this->getRequired() . '>';
        }
        return '';
    }

    protected function generateTextArea($field, string $dataType): string
    {
        if ($dataType === 'textarea') {
            return "<textarea name=\"{$field}\" id=\"{$field}\""
                . $this->getPlaceHolder()
                . $this->getRequired()
                . '>'
                . '{{ old(\'' . $field . '\') }}'
                . '</textarea>';
        }
        return '';
    }

    protected function generateSelect($field, string $dataType): string
    {
        $parser = new ModelParser($this->model);
        $relationships =  $parser->getRelationships();
        $relationField = $this->stripId($field);
        if ($dataType === 'select' && $this->hasValidRelation($relationships, $field)) {
            return "<select name=\"{$field}\" id=\"{$field}\""
                . $this->getRequired() . ">\n"
                . "\t@foreach(\$"
                . strtolower($this->model)
                . "->"
                . Str::plural($relationField)
                . " as \$"
                . $relationField
                . ")\n"
                . "\t\t<option value=\"{{ \$"
                . $relationField
                . "->id }}\">{{ \$"
                . $relationField
                . "->"
                . $relationField
                . " }}</option>\n"
                . "\t@endforeach\n"
                . '</select>';
        }
        return '';
    }

    private function hasValidRelation($relationships, $field): bool
    {
        $method = $this->stripId($field);
        $methods = Str::plural($this->stripId($field));

        if(isset($relationships[$method])
            && $relationships[$method] !== 'hasOne') {
            return true;
        }

        if(isset($relationships[$methods])
            && $relationships[$methods] !== 'hasOne') {
            return true;
        }
        return false;
    }

    protected function stripId($field): bool|string
    {
        return substr($field, 0, -3);
    }

    protected function getPlaceHolder(): string
    {
        if ($this->placeHolder !== '') {
            return " {$this->placeHolder}";
        }
        return '';
    }

    protected function getRequired(): string
    {
        if ($this->required !== '') {
            return " {$this->required}";
        }
        return '';
    }
}