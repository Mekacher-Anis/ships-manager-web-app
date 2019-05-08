<?php
echo "<table>";
foreach($_SERVER as $key => $value)
    echo "<tr><td>$key</td><td>$value</td></tr>";
echo "</table>";
