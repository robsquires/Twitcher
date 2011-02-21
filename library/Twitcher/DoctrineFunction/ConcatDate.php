<?php

namespace Twitcher\DoctrineFunction;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * "CONCAT" "(" StringPrimary "," StringPrimary "," StringPrimary ")"
 *
 * 
 * @author  Rob Squires
 */
class ConcatDate extends FunctionNode
{
    public $firstStringPrimary;
    public $secondStringPriamry;
    public $thirdStringPriamry;
    /**
     * @override
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $platform = $sqlWalker->getConnection()->getDatabasePlatform();
        return $platform->getConcatExpression(
            $sqlWalker->walkStringPrimary($this->firstStringPrimary),
            $sqlWalker->walkStringPrimary($this->secondStringPrimary),
            $sqlWalker->walkStringPrimary($this->thirdStringPrimary)
        );
    }

    /**
     * @override
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstStringPrimary = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->secondStringPrimary = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->thirdStringPrimary = $parser->ArithmeticPrimary();
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}

