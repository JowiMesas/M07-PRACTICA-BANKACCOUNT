<?php namespace ComBank\OverdraftStrategy;

use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:39 PM
 */

/**
 * @description: Grant 100.00 overdraft funds.
 * */
class SilverOverdraft implements OverdraftInterface
{
    public function isGrantOverdraftFunds($float) : bool {
return $float >= 0;
    }

    public function isOverdraftFundsAmount() : float {
        return $float > amount;
    }
    
}
