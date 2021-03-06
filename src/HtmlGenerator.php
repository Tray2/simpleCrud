<?php


namespace Tray2\SimpleCrud;


use Illuminate\Support\Str;

class HtmlGenerator
{
    protected $model;

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
        $required = $this->setRequired($parameter['required']);
        $placeholder = $this->setPlaceholder($parameter['default']);

        $html = $this->generateInput($parameter['field'], $dataType, $placeholder, $required);
        $html .= $this->generateTextArea($parameter['field'], $dataType, $placeholder, $required);
        $html .= $this->generateSelect($parameter['field'], $dataType, $required);
        return $html;
    }

    protected function setRequired($required): string
    {
        if ($required == 'YES') return ' required';
        return '';
    }

    protected function setPlaceholder($default): string
    {
        if ($default != '') return ' placeholder="' . $default . '"';
        return '';
    }

    protected function generateInput($field, string $dataType, string $placeholder, string $required): string
    {
        if ($dataType != 'textarea' && $dataType != 'select') {
            return '<input type="' . $dataType . '" name="' . $field
                . '" id="' . $field
                . '" value="{{ old(\'' . $field
                . '\') }}"'
                . $placeholder
                . $required . '>';
        }
        return '';
    }

    protected function generateTextArea($field, string $dataType, string $placeholder, string $required): string
    {
        if ($dataType == 'textarea') {
            return '<textarea name="' . $field
                . '" id="' . $field
                . '" value="{{ old(\'' . $field
                . '\') }}"'
                . $placeholder
                . $required . '></textarea>';
        }
        return '';
    }

    protected function generateSelect($field, string $dataType, string $required): string
    {
        $parser = new ModelParser($this->model);
        $relationships =  $parser->getRelationships();
        $relationField = $this->stripId($field);
        if ($this->hasValidRelation($relationships, $field)) {
            if ($dataType == 'select') {
                return '<select name="' . $field
                    . '" id="' . $field
                    . '"'
                    . $required . ">\n"
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
        }
        return '';
    }

    private function hasValidRelation($relationships, $field): bool
    {
        $method = substr($field, 0, -3);
        $methods = Str::plural(substr($field, 0, -3));

        if(isset($relationships[$method])
            && $relationships[$method] != 'hasOne') {
            return true;
        }

        if(isset($relationships[$methods])
            && $relationships[$methods] != 'hasOne') {
            return true;
        }
        return false;
    }

    protected function stripId($field)
    {
        return substr($field, 0, -3);
    }
}