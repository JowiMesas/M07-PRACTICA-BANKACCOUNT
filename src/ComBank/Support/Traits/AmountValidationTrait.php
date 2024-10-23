<?php namespace ComBank\Support\Traits;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 2:35 PM
 */

use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;

trait AmountValidationTrait
{
    /**
     * @param float $amount
     * @throws InvalidArgsException
     * @throws ZeroAmountException
     */
    public function validateAmount(float $amount):void
    {
        if(!is_numeric($amount)) {
            throw new InvalidArgsException("The amount has to be numerical");
        }
        if($amount <= 0) {
            throw new ZeroAmountException("The amount cannot be zero");
        }
    }
}
