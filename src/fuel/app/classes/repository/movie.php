<?php

class Repository_Movie extends Repository_Base
{
    function get_model()
    {
        return Model_Movie::class;
    }
}