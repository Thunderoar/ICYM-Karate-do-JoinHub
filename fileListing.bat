@echo off
set "rootDir=C:\wamp64\www"
setlocal enabledelayedexpansion

echo Directory Listing Script
echo =====================
echo.

echo Current Directory: %CD%
echo.

echo Files in current directory:
echo -------------------------
for /F "delims=" %%i in ('dir /B /A-D') do (
    set "file=%%i"
    echo !file:%rootDir%\=!
)
echo.

echo Files in subdirectories:
echo ----------------------
for /F "delims=" %%i in ('dir /B /S /A-D') do (
    set "file=%%i"
    echo !file:%rootDir%\=!
)

echo.
echo Folders:
echo --------
for /F "delims=" %%i in ('dir /B /AD') do (
    set "folder=%%i"
    echo !folder:%rootDir%\=!
)

pause
