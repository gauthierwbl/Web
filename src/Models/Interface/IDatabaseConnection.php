<?php

interface IDatabaseConnection {
    public function connect();
    public function disconnect();
    public function getConnection();
}
