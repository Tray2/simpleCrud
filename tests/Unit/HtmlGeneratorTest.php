<?php


namespace Tray2\SimpleCrud\Tests\Unit;


use Tray2\SimpleCrud\HtmlGenerator;
use Tray2\SimpleCrud\Tests\TestCase;

class HtmlGeneratorTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_instantiate_the_class()
    {
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertInstanceOf(HtmlGenerator::class, $htmlGenerator);
    }

    /**
    * @test
    */
    public function it_can_generate_a_label()
    {
        $expected = "\t<label for=\"title\"></label>\n";
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generateLabel('title'));
    }

    /**
    * @test
    */
    public function it_can_generate_a_text_input()
    {
        $parameter = [
            'field' => 'title',
            'type' => 'varchar',
            'required' => 'NO',
            'default' => ''
        ];
        $expected = '<input type="text" name="title" id="title" value="{{ old(\'title\') }}">';
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }

    /**
     * @test
     */
    public function it_can_generate_a_required_text_input()
    {
        $parameter = [
            'field' => 'title',
            'type' => 'varchar',
            'required' => 'YES',
            'default' => ''
        ];
        $expected = '<input type="text" name="title" id="title" value="{{ old(\'title\') }}" required>';
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }

    /**
     * @test
     */
    public function it_can_generate_a_text_input_with_name_and_id_from_the_field()
    {
        $parameter = [
            'field' => 'subtitle',
            'type' => 'varchar',
            'required' => 'NO',
            'default' => ''
        ];
        $expected = '<input type="text" name="subtitle" id="subtitle" value="{{ old(\'subtitle\') }}">';
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }

    /**
     * @test
     */
    public function it_can_generate_a_text_input_old_value_from_the_field()
    {
        $parameter = [
            'field' => 'subtitle',
            'type' => 'varchar',
            'required' => 'NO',
            'default' => ''
        ];
        $expected = '<input type="text" name="subtitle" id="subtitle" value="{{ old(\'subtitle\') }}">';
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }

    /**
     * @test
     */
    public function if_the_default_is_set_its_used_to_set_a_placeholder()
    {
        $parameter = [
            'field' => 'subtitle',
            'type' => 'varchar',
            'required' => 'NO',
            'default' => 'subtitle'
        ];
        $expected = '<input type="text" name="subtitle" id="subtitle" value="{{ old(\'subtitle\') }}" placeholder="subtitle">';
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }

    /**
    * @test
    */
    public function it_can_generate_a_number_input()
    {
        $parameter = [
            'field' => 'no_of_tracks',
            'type' => 'tinyint',
            'required' => 'YES',
            'default' => ''
        ];
        $expected = '<input type="number" name="no_of_tracks" id="no_of_tracks" value="{{ old(\'no_of_tracks\') }}" required>';
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }

    /**
     * @test
     */
    public function it_can_generate_a_date_input()
    {
        $parameter = [
            'field' => 'published_at',
            'type' => 'timestamp',
            'required' => 'YES',
            'default' => ''
        ];
        $expected = '<input type="date" name="published_at" id="published_at" value="{{ old(\'published_at\') }}" required>';
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }

    /**
     * @test
     */
    public function it_can_generate_a_textarea()
    {
        $parameter = [
            'field' => 'blurb',
            'type' => 'tinytext',
            'required' => 'YES',
            'default' => ''
        ];
        $expected = '<textarea name="blurb" id="blurb" value="{{ old(\'blurb\') }}" required></textarea>';
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }
    
    /**
    * @test
    */
    public function if_a_foreign_key_is_passed_it_generates_a_select_element()
    {
        $parameter = [
            'field' => 'format_id',
            'type' => 'bigint',
            'required' => 'YES',
            'default' => ''
        ];
        $expected = "<select name=\"format_id\" id=\"format_id\" required>\n";
        $expected .= "\t@foreach(\$books->formats as \$format)\n";
        $expected .= "\t\t<option value=\"{{ \$format->id }}\">{{ \$format->format }}</option>\n";
        $expected .= "\t@endforeach\n";
        $expected .= "</select>";
        $htmlGenerator = new HtmlGenerator('Book');
        $this->assertEquals($expected, $htmlGenerator->generate($parameter));
    }

}