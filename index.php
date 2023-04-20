<?php

require 'app/Bootstrap.php';

$container->resolve('SortFile', 'data/input', 'data/output', 'Command.Sort.Selection');
