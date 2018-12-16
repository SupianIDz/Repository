<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                     |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @version : v1.0
 * @license : MIT
 */

namespace Octopy\Debug\DebugBar\Collector;

use Octopy\Support\View;

class ExceptionCollector
{
    /**
     * @var string
     */
    public $title = 'Exception';

    /**
     * @return array
     */
    public function collect() : array
    {
        return [];
    }

    /**
     * @return string
     */
    public function icon() : string
    {
        return 'data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjUxMXB0IiB2aWV3Qm94PSIwIDAgNTExLjk5OTI4IDUxMSIgd2lkdGg9IjUxMXB0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGwtcnVsZT0iZXZlbm9kZCI+PHBhdGggZD0ibTQyNy41MDM5MDYgMjcuMzk4NDM4LTguODE2NDA2LTIuMzUxNTYzLTU0LjIyNjU2Mi0xNC41NDI5NjktMzkuNzEwOTM4IDM5LjcxNDg0NC0zOS43MTA5MzggMzkuNjc5Njg4IDEyLjgzOTg0NCA0Ny45MDYyNS0xNjAuNTc0MjE4IDE2MC41NzQyMTgtNDcuOTAyMzQ0LTEyLjgzOTg0NC0zOS43MTQ4NDQgMzkuNzEwOTM4LTM5LjY3OTY4OCAzOS43MTA5MzggMTQuNTM5MDYzIDU0LjIyNjU2MiAyLjM1MTU2MyA4LjgxMjUgNTkuMzgyODEyLTU5LjM3ODkwNiAyMi43MDcwMzEgNi4wNjI1IDIyLjcwMzEyNSA2LjA5Mzc1IDYuMDkzNzUgMjIuNzA3MDMxIDYuMDk3NjU2IDIyLjcwMzEyNS01OS40MTQwNjIgNTkuNDEwMTU2IDguODE2NDA2IDIuMzU1NDY5IDU0LjI1IDE0LjUzOTA2MyAzOS42ODM1OTQtMzkuNzEwOTM4IDM5LjcxNDg0NC0zOS43MTA5MzgtMTIuODQzNzUtNDcuODc1IDE2MC42MDU0NjgtMTYwLjYwNTQ2OCA0Ny44NzUgMTIuODM5ODQ0IDM5LjcxMDkzOC0zOS43MTA5MzggMzkuNzEwOTM4LTM5LjY4MzU5NC0xNC41MzkwNjMtNTQuMjIyNjU2LTIuMzgyODEzLTguODQzNzUtNTkuMzgyODEyIDU5LjQxMDE1Ni0yMi43MDMxMjUtNi4wOTM3NS0yMi43MDMxMjUtNi4wNjY0MDYtNi4wOTM3NS0yMi43MDMxMjUtNi4wNjY0MDYtMjIuNzAzMTI1em0wIDAiIGZpbGw9IiNmZWM5NmIiLz48cGF0aCBkPSJtMzIwLjM4NjcxOSAyMzIuNTM1MTU2YzQ4Ljc1MzkwNiAwIDg4LjMyNDIxOSAzOS41NzAzMTMgODguMzI0MjE5IDg4LjM1MTU2M3MtMzkuNTcwMzEzIDg4LjMyMDMxMi04OC4zMjQyMTkgODguMzIwMzEyYy00OC43ODEyNSAwLTg4LjM1MTU2My0zOS41MzkwNjItODguMzUxNTYzLTg4LjMyMDMxMnMzOS41NzAzMTMtODguMzUxNTYzIDg4LjM1MTU2My04OC4zNTE1NjN6bTAgMCIgZmlsbD0iIzY3ZTRkYyIvPjxwYXRoIGQ9Im01MTEuNjU2MjUgMTQ1LjQ0NTMxMi0xNC41NDI5NjktNTQuMjM0Mzc0LTIuMzc4OTA2LTguODQzNzVjLS45MzM1OTQtMy40NDkyMTktMy42Mjg5MDYtNi4xNDQ1MzItNy4wODIwMzEtNy4wNjY0MDdzLTcuMTMyODEzLjA2NjQwNy05LjY1NjI1IDIuNTkzNzVsLTU1LjI5Njg3NSA1NS4zMjQyMTktMzQuMjUzOTA3LTkuMTcxODc1LTkuMTY3OTY4LTM0LjI0MjE4NyA1NS4zMDA3ODEtNTUuMzMyMDMyYzIuNTI3MzQ0LTIuNTI3MzQ0IDMuNTE1NjI1LTYuMjE0ODQ0IDIuNTg5ODQ0LTkuNjY3OTY4LS45Mjk2ODgtMy40NTMxMjYtMy42Mjg5MDctNi4xNDg0MzgtNy4wODU5MzgtNy4wNzQyMTlsLTYzLjAyNzM0My0xNi44OTA2MjVjLTMuNDU3MDMyLS45MjU3ODE1LTcuMTQwNjI2LjA2MjUtOS42Njc5NjkgMi41ODk4NDRsLTM5LjcwNzAzMSAzOS43MTA5MzctMzkuNzE0ODQ0IDM5LjY4MzU5NGMtMi41MjczNDQgMi41MjczNDMtMy41MTU2MjUgNi4yMTQ4NDMtMi41ODk4NDQgOS42Njc5NjlsMTEuMzQzNzUgNDIuMzI0MjE4LTQ3LjkyNTc4MSA0Ny45MjU3ODJjLTMuOTEwMTU3IDMuOTEwMTU2LTMuOTEwMTU3IDEwLjI0NjA5MyAwIDE0LjE1MjM0MyAzLjkwNjI1IDMuOTA2MjUgMTAuMjQyMTg3IDMuOTA2MjUgMTQuMTQ4NDM3IDBsNTIuMDExNzE5LTUyLjAxNTYyNWMyLjUzMTI1LTIuNTI3MzQ0IDMuNTE5NTMxLTYuMjEwOTM3IDIuNTg5ODQ0LTkuNjY0MDYybC0xMS4zNDM3NS00Mi4zMjAzMTMgNzEuMjUtNzEuMjI2NTYyIDQwLjcyMjY1NiAxMC45MTc5NjktNDcuMTI4OTA2IDQ3LjE1MjM0M2MtMi41MjczNDQgMi41MjczNDQtMy41MTE3MTkgNi4yMDcwMzEtMi41ODk4NDQgOS42NTYyNWwxMi4xNjAxNTYgNDUuNDE3OTY5Yy45Mjk2ODggMy40NTcwMzEgMy42Mjg5MDcgNi4xNTIzNDQgNy4wODIwMzEgNy4wNzQyMTlsNDUuMzk4NDM4IDEyLjE2MDE1NmMzLjQ1NzAzMS45Mjk2ODcgNy4xNDQ1MzEtLjA2MjUgOS42NzE4NzUtMi41ODk4NDRsNDcuMTM2NzE5LTQ3LjE2NDA2MiAxMC45Mjk2ODcgNDAuNzUzOTA2LTcxLjI1IDcxLjIyMjY1Ni00Mi4yOTY4NzUtMTEuMzQzNzVjLTMuNDUzMTI1LS45MjU3ODEtNy4xMzY3MTguMDYyNS05LjY2NDA2MiAyLjU4OTg0NGwtMTkuMTE3MTg4IDE5LjExNzE4N2MtOC45MTQwNjItMi42Njc5NjgtMTguMzUxNTYyLTQuMTA1NDY4LTI4LjExNzE4Ny00LjEwNTQ2OC01NC4yMzQzNzUgMC05OC4zNTkzNzUgNDQuMTI1LTk4LjM1OTM3NSA5OC4zNTkzNzUgMCA5Ljc2OTUzMSAxLjQ0MTQwNiAxOS4yMDcwMzEgNC4xMDU0NjggMjguMTE3MTg3bC0xOS4xMTcxODcgMTkuMTE3MTg4Yy0yLjUyNzM0NCAyLjUyNzM0NC0zLjUxNTYyNSA2LjIxNDg0NC0yLjU4OTg0NCA5LjY2Nzk2OGwxMS4zNDM3NSA0Mi4yOTI5NjktNzEuMjI2NTYyIDcxLjI1LTQwLjczODI4MS0xMC45MTc5NjkgNDcuMTQ4NDM3LTQ3LjE0ODQzN2MyLjUzMTI1LTIuNTMxMjUgMy41MTk1MzEtNi4yMTg3NSAyLjU4OTg0NC05LjY3MTg3NWwtMTIuMTg3NS00NS40MTAxNTZjLS45MjU3ODEtMy40NDkyMTktMy42MjEwOTQtNi4xNDA2MjUtNy4wNzAzMTMtNy4wNjY0MDZsLTQ1LjQxNzk2OC0xMi4xNjQwNjNjLTMuNDUzMTI2LS45MjE4NzUtNy4xMzI4MTMuMDY2NDA2LTkuNjYwMTU3IDIuNTg5ODQ0bC00Ny4xMjEwOTMgNDcuMTIxMDkzLTEwLjkxNzk2OS00MC43MTQ4NDMgNzEuMjIyNjU2LTcxLjI1IDQyLjMyNDIxOSAxMS4zNDM3NWMzLjQ1MzEyNS45MjU3ODEgNy4xNDA2MjUtLjA2MjUgOS42NjQwNjItMi41ODU5MzhsNTIuMDE1NjI1LTUyLjAxNTYyNWMzLjkwNjI1LTMuOTEwMTU2IDMuOTA2MjUtMTAuMjQyMTg3IDAtMTQuMTUyMzQ0LTMuOTA2MjUtMy45MDYyNS0xMC4yNDYwOTMtMy45MDYyNS0xNC4xNDg0MzcgMGwtNDcuOTI5Njg4IDQ3LjkyOTY4OC00Mi4zMjQyMTgtMTEuMzQzNzVjLTMuNDUzMTI2LS45MjU3ODEtNy4xMzY3MTkuMDYyNS05LjY2NDA2MyAyLjU4NTkzOGwtMzkuNzE0ODQ0IDM5LjcxNDg0My0zOS42ODM1OTMgMzkuNzE0ODQ0Yy0yLjUyNzM0NCAyLjUyNzM0NC0zLjUxNTYyNiA2LjIxMDkzNy0yLjU4OTg0NCA5LjY2NDA2M2wxNC41MzkwNjIgNTQuMjEwOTM3IDIuMzU1NDY5IDguODE2NDA2Yy45MjE4NzUgMy40NTcwMzEgMy42MTcxODcgNi4xNTYyNSA3LjA3MDMxMyA3LjA4MjAzMSAzLjQ1MzEyNC45Mjk2ODggNy4xNDA2MjQtLjA1ODU5MyA5LjY3MTg3NC0yLjU4NTkzN2w1NS4zMDA3ODItNTUuMzAwNzgxIDM0LjI0NjA5NCA5LjE2Nzk2OCA5LjE5NTMxMiAzNC4yNTM5MDctNTUuMzI0MjE5IDU1LjMyNDIxOWMtMi41MjczNDMgMi41MjczNDMtMy41MTU2MjUgNi4yMTQ4NDMtMi41ODk4NDMgOS42Njc5NjguOTI5Njg3IDMuNDU3MDMyIDMuNjI4OTA2IDYuMTUyMzQ0IDcuMDg1OTM3IDcuMDc0MjE5bDYzLjA1NDY4NyAxNi44OTA2MjVjLjg1OTM3Ni4yMzA0NjkgMS43MjY1NjMuMzQzNzUgMi41ODk4NDQuMzQzNzUgMi42MjEwOTQgMCA1LjE3OTY4OC0xLjAzMTI1IDcuMDc4MTI1LTIuOTMzNTk0bDM5LjY4MzU5NC0zOS43MTA5MzcgMzkuNzEwOTM3LTM5LjcxMDkzOGMyLjUyNzM0NC0yLjUyNzM0MyAzLjUxNTYyNi02LjIxNDg0MyAyLjU4OTg0NC05LjY2Nzk2OWwtMTEuMzQzNzUtNDIuMjkyOTY4IDkuMzA4NTk0LTkuMzA4NTk0YzE2Ljg1OTM3NSAzMC4wMTE3MTkgNDkuMDExNzE5IDUwLjMzOTg0NCA4NS44MjQyMTkgNTAuMzM5ODQ0IDIyLjg5MDYyNSAwIDQ0LjU5Mzc1LTcuNzc3MzQ0IDYyLjA4OTg0My0yMi4wODU5MzhsNTUuNzIyNjU3IDU1LjcyMjY1NmMxLjk1MzEyNSAxLjk1MzEyNiA0LjUxNTYyNSAyLjkyOTY4OCA3LjA3ODEyNSAyLjkyOTY4OCAyLjU1ODU5NCAwIDUuMTIxMDk0LS45NzY1NjIgNy4wNzQyMTgtMi45Mjk2ODggMy45MDYyNS0zLjkxMDE1NiAzLjkwNjI1LTEwLjI0NjA5MyAwLTE0LjE1MjM0M2wtNTUuNzIyNjU2LTU1LjcyMjY1N2MxNC4zMDg1OTQtMTcuNDk2MDkzIDIyLjA4NTkzOC0zOS4xOTkyMTggMjIuMDg1OTM4LTYyLjA4OTg0MyAwLTM2LjgxMjUtMjAuMzI4MTI1LTY4Ljk2NDg0NC01MC4zMzk4NDQtODUuODIwMzEzbDkuMzA4NTk0LTkuMzEyNSA0Mi4yOTI5NjggMTEuMzQzNzVjMy40NTcwMzIuOTI1NzgyIDcuMTQwNjI2LS4wNjI1IDkuNjY3OTY5LTIuNTg5ODQ0bDM5LjcxMDkzOC0zOS43MDcwMzEgMzkuNzEwOTM3LTM5LjY4NzVjMi41MzEyNS0yLjUyNzM0MyAzLjUxNTYyNS02LjIxNDg0MyAyLjU4OTg0NC05LjY2Nzk2OXptLTExMi45NTMxMjUgMTc1LjQ0MTQwN2MwIDIwLjkwNjI1LTguMTQ4NDM3IDQwLjU3MDMxMi0yMi45NDkyMTkgNTUuMzY3MTg3LTE0Ljc5Njg3NSAxNC44MDA3ODItMzQuNDYwOTM3IDIyLjk0OTIxOS01NS4zNjcxODcgMjIuOTQ5MjE5LTMzLjY1MjM0NCAwLTYyLjQxNDA2My0yMS4zMjQyMTktNzMuNDg0Mzc1LTUxLjE2MDE1Ni0uMDIzNDM4LS4wNjI1LS4wNDY4NzUtLjEyNS0uMDcwMzEzLS4xODM1OTQtMy4wOTc2NTYtOC40MTQwNjMtNC43OTI5NjktMTcuNS00Ljc5Mjk2OS0yNi45NzY1NjMgMC00My4xOTkyMTggMzUuMTQ4NDM4LTc4LjM0Mzc1IDc4LjM0NzY1Ny03OC4zNDM3NSA5LjQ4MDQ2OSAwIDE4LjU3NDIxOSAxLjY5NTMxMyAyNi45OTYwOTMgNC43OTY4NzYuMDQyOTY5LjAxOTUzMS4wODIwMzIuMDM1MTU2LjEyNS4wNTA3ODEgMjkuODU5Mzc2IDExLjA2MjUgNTEuMTk1MzEzIDM5LjgzMjAzMSA1MS4xOTUzMTMgNzMuNXptMCAwIi8+PHBhdGggZD0ibTIxNy42MDU0NjkgMjI4LjA4MjAzMWM1LjUgMCA5Ljk3NjU2Mi00LjQ3NjU2MiA5Ljk3NjU2Mi05Ljk3NjU2MiAwLTUuNTI3MzQ0LTQuNDc2NTYyLTEwLjAwMzkwNy05Ljk3NjU2Mi0xMC4wMDM5MDctNS41MjczNDQgMC0xMC4wMDM5MDcgNC40NzY1NjMtMTAuMDAzOTA3IDEwLjAwMzkwNyAwIDUuNSA0LjQ3NjU2MyA5Ljk3NjU2MiAxMC4wMDM5MDcgOS45NzY1NjJ6bTAgMCIvPjwvZz48L3N2Zz4=';
    }
}
