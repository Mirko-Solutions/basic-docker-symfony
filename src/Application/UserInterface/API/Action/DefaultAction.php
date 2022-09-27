<?php

namespace App\UserInterface\API\Action;

use App\UserInfrastructure\API\Response\ArrayResponse;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class DefaultAction extends AbstractAction
{
    public function __invoke()
    {
        return $this->responseCollection(new ArrayResponse(), [
            [1, 2], [3, 4]
        ]);
    }
}
