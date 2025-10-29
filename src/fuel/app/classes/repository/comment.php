<?php

class Repository_Comment extends Repository_Base
{
    function get_model()
    {
        return Model_Comment::class;
    }
}
