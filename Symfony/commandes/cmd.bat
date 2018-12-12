@echo off
SCHTASKS /Create /SC DAILY /TN Oeuvre /TR C:\wamp\www\GrandAngle\Symfony\commandes\exec.bat /ST 21:36:00


