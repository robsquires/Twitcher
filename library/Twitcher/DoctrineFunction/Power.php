<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Twitcher\DoctrineFunction;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * Description of Hour
 *
 * @author Rob
 */
class Power extends FunctionNode {

    protected $powerExpression;
    protected $power;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'POWER(' .
                $sqlWalker->walkArithmeticExpression($this->powerExpression) .
                ','.
                $sqlWalker->walkArithmeticPrimary($this->power) .
                ')';

    }


    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->powerExpression = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_COMMA);
 
        
        $this->power = $parser->ArithmeticPrimary();
 
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);


    }

}

