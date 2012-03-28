<?php

class LatexAnalyzerTest extends PHPUnit_Framework_TestCase
{
    public $latex;
    
    public function setUp()
    {
        $this->latex = new LexicalAnalyzer\Analyzers\LatexAnalyzer;
    }
    
    public function testIsParsingText()
    {
        $tokens = $this->latex->parse("Lorem");
        $this->assertNotNull($tokens);
        $this->assertEquals(1, sizeof($tokens));
        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);
    }

    public function testIsParsingTextWithWhitespace()
    {
        $tokens = $this->latex->parse(" Lorem");
        $this->assertNotNull($tokens);
        $this->assertEquals(1, sizeof($tokens));
        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(2, $token->column);
    }

    public function testIsParsingTextWithNewlines()
    {
        $tokens = $this->latex->parse("\nLorem");
        $this->assertNotNull($tokens);
        $this->assertEquals(1, sizeof($tokens));
        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(2, $token->line);
        $this->assertEquals(1, $token->column);
    }

    public function testIsParsingTwoWords()
    {
        $tokens = $this->latex->parse("Lorem Ipsum");
        $this->assertNotNull($tokens);
        $this->assertEquals(2, sizeof($tokens));
        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);
        $token = $tokens[1];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Ipsum", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(7, $token->column);
    }

    public function testIsParsingPhrases()
    {
        $tokens = $this->latex->parse("Lorem Ipsum Dolor Sit Amet");
        $this->assertNotNull($tokens);
        $this->assertEquals(5, sizeof($tokens));

        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);

        $token = $tokens[1];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Ipsum", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(7, $token->column);

        $token = $tokens[2];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Dolor", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(13, $token->column);

        $token = $tokens[3];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Sit", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(19, $token->column);

        $token = $tokens[4];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Amet", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(23, $token->column);
    }
    
    public function testIsParsingWordsPerLine()
    {
        $tokens = $this->latex->parse("Lorem\nIpsum\nDolor\nSit\nAmet");
        $this->assertNotNull($tokens);
        $this->assertEquals(5, sizeof($tokens));

        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);

        $token = $tokens[1];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Ipsum", $token->value);
        $this->assertEquals(2, $token->line);
        $this->assertEquals(1, $token->column);

        $token = $tokens[2];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Dolor", $token->value);
        $this->assertEquals(3, $token->line);
        $this->assertEquals(1, $token->column);

        $token = $tokens[3];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Sit", $token->value);
        $this->assertEquals(4, $token->line);
        $this->assertEquals(1, $token->column);

        $token = $tokens[4];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Amet", $token->value);
        $this->assertEquals(5, $token->line);
        $this->assertEquals(1, $token->column);
    }
    
    public function testIsParsingMultipleEvenNewlines()
    {
        $tokens = $this->latex->parse("Lorem\n\n\n\nIpsum");
        $this->assertNotNull($tokens);
        $this->assertEquals(2, sizeof($tokens));

        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);

        $token = $tokens[1];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Ipsum", $token->value);
        $this->assertEquals(5, $token->line);
        $this->assertEquals(1, $token->column);
    }
    
    public function testIsParsingMultipleOddNewlines()
    {
        $tokens = $this->latex->parse("Lorem\n\n\n\n\nIpsum");
        $this->assertNotNull($tokens);
        $this->assertEquals(2, sizeof($tokens));

        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);

        $token = $tokens[1];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Ipsum", $token->value);
        $this->assertEquals(6, $token->line);
        $this->assertEquals(1, $token->column);
    }
    
    public function testIsParsingCommands()
    {
        $tokens = $this->latex->parse("Lorem \input{base}");
        $this->assertNotNull($tokens);
        $this->assertEquals(2, sizeof($tokens));
        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);
        $token = $tokens[1];
        $this->assertEquals("T_LATEX_COMMAND", $token->type);
        $this->assertEquals("\input{base}", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(7, $token->column);
    }
    
    public function testIsParsingMultipleCommands()
    {
        $tokens = $this->latex->parse("Lorem \input{base} \input{config}");
        $this->assertNotNull($tokens);
        $this->assertEquals(3, sizeof($tokens));
        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);
        $token = $tokens[1];
        $this->assertEquals("T_LATEX_COMMAND", $token->type);
        $this->assertEquals("\input{base}", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(7, $token->column);
        $token = $tokens[2];
        $this->assertEquals("T_LATEX_COMMAND", $token->type);
        $this->assertEquals("\input{config}", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(20, $token->column);
    }
    
    public function testIsParsingMultipleCommandsAndNewlines()
    {
        $tokens = $this->latex->parse("Lorem\n\n\input{base}\n\input{config}");
        $this->assertNotNull($tokens);
        $this->assertEquals(3, sizeof($tokens));
        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);
        $token = $tokens[1];
        $this->assertEquals("T_LATEX_COMMAND", $token->type);
        $this->assertEquals("\input{base}", $token->value);
        $this->assertEquals(3, $token->line);
        $this->assertEquals(1, $token->column);
        $token = $tokens[2];
        $this->assertEquals("T_LATEX_COMMAND", $token->type);
        $this->assertEquals("\input{config}", $token->value);
        $this->assertEquals(4, $token->line);
        $this->assertEquals(1, $token->column);
    }
    
    public function testParsingBeginDocumentCommand()
    {
        $tokens = $this->latex->parse('\begin{document}');
        $this->assertNotNull($tokens);
        $this->assertEquals(1, sizeof($tokens));
        $this->assertEquals('T_LATEX_COMMAND', $tokens[0]->type);
        $this->assertEquals('\begin{document}', $tokens[0]->value);
    }

    public function testParsingFrontmatterCommand()
    {
        $tokens = $this->latex->parse('\frontmatter');
        $this->assertNotNull($tokens);
        $this->assertEquals(1, sizeof($tokens));
        $this->assertEquals('T_LATEX_COMMAND', $tokens[0]->type);
        $this->assertEquals('\frontmatter', $tokens[0]->value);
    }
 
    public function testIsParsingCommandsWithoutParameters()
    {
        $tokens = $this->latex->parse('Lorem \frontmatter');
        $this->assertNotNull($tokens);
        $this->assertEquals(2, sizeof($tokens));
        $token = $tokens[0];
        $this->assertEquals("T_WORD", $token->type);
        $this->assertEquals("Lorem", $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(1, $token->column);
        $token = $tokens[1];
        $this->assertEquals("T_LATEX_COMMAND", $token->type);
        $this->assertEquals('\frontmatter', $token->value);
        $this->assertEquals(1, $token->line);
        $this->assertEquals(7, $token->column);
    }
}
