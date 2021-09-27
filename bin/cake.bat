::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::
:: Cake is a Windows batch script for invoking CakePHP shell commands
::
:: @copyright     Copyright (c) INASSA 2017
:: @link          http://nassagroup.com
::
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

@echo off

SET app=%0
SET lib=%~dp0

php "%lib%cake.php" %*

echo.

exit /B %ERRORLEVEL%
