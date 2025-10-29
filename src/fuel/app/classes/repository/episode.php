<?php

class Repository_Episode extends Repository_Base
{
    function get_model()
    {
        return Model_Movie_Episode::class;
    }
}
