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

use Octopy\Support\Session;

class SessionCollector
{
    /**
     * @var string
     */
    public $title = 'Session';

    /**
     * @return array
     */
    public function collect() : array
    {
        return Session::all();
    }

    /**
     * @return string
     */
    public function icon() : string
    {
        return 'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8cGF0aCBzdHlsZT0iZmlsbDojRkZGRkZGOyIgZD0iTTQ3NSw4OHYzNzRjMCwyMi4wOTEtMTcuOTA5LDQwLTQwLDQwSDc3Yy0yMi4wOTEsMC00MC0xNy45MDktNDAtNDBWNTBjMC0yMi4wOTEsMTcuOTA5LTQwLDQwLTQwICBoMzE1Ljk4OEw0NzUsODh6Ii8+CjxyZWN0IHg9Ijk2IiB5PSIzNTIiIHN0eWxlPSJmaWxsOiNGRjVBNUE7IiB3aWR0aD0iODAiIGhlaWdodD0iODAiLz4KPHJlY3QgeD0iMjE2IiB5PSIzNTIiIHN0eWxlPSJmaWxsOiM3OEQyRkE7IiB3aWR0aD0iODAiIGhlaWdodD0iODAiLz4KPGc+Cgk8cmVjdCB4PSIzMzYiIHk9IjM1MiIgc3R5bGU9ImZpbGw6I0E1REM2OTsiIHdpZHRoPSI4MCIgaGVpZ2h0PSI4MCIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0E1REM2OTsiIGQ9Ik0zNzYsMTY0TDM3NiwxNjRjMjIuMDkxLDAsNDAtMTcuOTA5LDQwLTQwbDAsMGMwLTIyLjA5MS0xNy45MDktNDAtNDAtNDBsMCwwICAgYy0yMi4wOTEsMC00MCwxNy45MDktNDAsNDBsMCwwQzMzNiwxNDYuMDkxLDM1My45MDksMTY0LDM3NiwxNjR6Ii8+CjwvZz4KPHBhdGggc3R5bGU9ImZpbGw6Izc4RDJGQTsiIGQ9Ik0yNTYsMTY0TDI1NiwxNjRjMjIuMDkxLDAsNDAtMTcuOTA5LDQwLTQwbDAsMGMwLTIyLjA5MS0xNy45MDktNDAtNDAtNDBsMCwwICBjLTIyLjA5MSwwLTQwLDE3LjkwOS00MCw0MGwwLDBDMjE2LDE0Ni4wOTEsMjMzLjkwOSwxNjQsMjU2LDE2NHoiLz4KPHBhdGggc3R5bGU9ImZpbGw6I0ZGNUE1QTsiIGQ9Ik0xMzYsMTY0TDEzNiwxNjRjMjIuMDkxLDAsNDAtMTcuOTA5LDQwLTQwbDAsMGMwLTIyLjA5MS0xNy45MDktNDAtNDAtNDBsMCwwICBjLTIyLjA5MSwwLTQwLDE3LjkwOS00MCw0MGwwLDBDOTYsMTQ2LjA5MSwxMTMuOTA5LDE2NCwxMzYsMTY0eiIvPgo8cmVjdCB4PSIxNzAiIHk9IjIxNiIgc3R5bGU9ImZpbGw6I0Y1Qzg2RTsiIHdpZHRoPSIxNzIiIGhlaWdodD0iODAiLz4KPHBhdGggc3R5bGU9ImZpbGw6Izc4RDJGQTsiIGQ9Ik00NzUsODhoLTM4LjAxNWMtMjIuMDkxLDAtNDAtMTcuOTA5LTQwLTQwVjEwTDQ3NSw4OHoiLz4KPHBhdGggZD0iTTI4NCwyNjYuMTNjMi42MywwLDUuMjEtMS4wNyw3LjA3LTIuOTNjMS44Ni0xLjg2LDIuOTMtNC40NCwyLjkzLTcuMDdjMC0yLjY0LTEuMDctNS4yMS0yLjkzLTcuMDcgIGMtMS44Ni0xLjg3LTQuNDQtMi45My03LjA3LTIuOTNzLTUuMjEsMS4wNi03LjA3LDIuOTNjLTEuODYsMS44Ni0yLjkzLDQuNDQtMi45Myw3LjA3czEuMDcsNS4yMSwyLjkzLDcuMDcgIEMyNzguNzksMjY1LjA2LDI4MS4zNywyNjYuMTMsMjg0LDI2Ni4xM3oiLz4KPHBhdGggZD0iTTQ3NSwyNzdjLTIuNjMsMC01LjIxLDEuMDY5LTcuMDcsMi45M2MtMS44NiwxLjg2LTIuOTMsNC40NC0yLjkzLDcuMDdzMS4wNyw1LjIxLDIuOTMsNy4wNjkgIGMxLjg2LDEuODYsNC40NCwyLjkzMSw3LjA3LDIuOTMxczUuMjEtMS4wNyw3LjA3LTIuOTMxYzEuODYtMS44NTksMi45My00LjQzOSwyLjkzLTcuMDY5cy0xLjA3LTUuMjEtMi45My03LjA3UzQ3Ny42MywyNzcsNDc1LDI3N3ogICIvPgo8cGF0aCBkPSJNNDgyLjA2Niw4MC45MjVMNDA0LjA1NSwyLjkyOWMtMi4zODgtMi4zODktNS43NzktMy4zNTUtOS4wMS0yLjcxNUMzOTQuMzgxLDAuMDc1LDM5My42OTMsMCwzOTIuOTg4LDBINzcgIEM0OS40MywwLDI3LDIyLjQzLDI3LDUwdjQxMmMwLDI3LjU3LDIyLjQzLDUwLDUwLDUwaDM1OGMyNy41NywwLDUwLTIyLjQzLDUwLTUwVjMzNS42NjdjMC01LjUyMi00LjQ3Ny0xMC0xMC0xMHMtMTAsNC40NzgtMTAsMTAgIFY0NjJjMCwxNi41NDItMTMuNDU4LDMwLTMwLDMwSDc3Yy0xNi41NDIsMC0zMC0xMy40NTgtMzAtMzBWNTBjMC0xNi41NDIsMTMuNDU4LTMwLDMwLTMwaDMwOS45ODV2MjggIGMwLDExLjcxMSw0LjA1OCwyMi40ODYsMTAuODI3LDMxLjAxN0MzOTEuMjE2LDc1LjgwNiwzODMuODE2LDc0LDM3Niw3NGMtMjcuNTcsMC01MCwyMi40My01MCw1MGMwLDI0LjE0NiwxNy4yMDUsNDQuMzQ4LDQwLDQ4Ljk5NCAgdjUwLjk4aC0xNFYyMTZjMC01LjUyMi00LjQ3Ny0xMC0xMC0xMGgtNzZ2LTMzLjAwNmMyMi43OTUtNC42NDYsNDAtMjQuODQ3LDQwLTQ4Ljk5NGMwLTI3LjU3LTIyLjQzLTUwLTUwLTUwcy01MCwyMi40My01MCw1MCAgYzAsMjQuMTQ2LDE3LjIwNSw0NC4zNDgsNDAsNDguOTk0VjIwNmgtNzZjLTUuNTIzLDAtMTAsNC40NzgtMTAsMTB2Ny45NzRoLTE0di01MC45OGMyMi43OTUtNC42NDYsNDAtMjQuODQ3LDQwLTQ4Ljk5NCAgYzAtMjcuNTctMjIuNDMtNTAtNTAtNTBzLTUwLDIyLjQzLTUwLDUwYzAsMjQuMTQ2LDE3LjIwNSw0NC4zNDgsNDAsNDguOTk0djYwLjk4YzAsNS41MjIsNC40NzcsMTAsMTAsMTBoMjRWMjY2aC0yNCAgYy01LjUyMywwLTEwLDQuNDc4LTEwLDEwdjY2SDk2Yy01LjUyMywwLTEwLDQuNDc4LTEwLDEwdjgwYzAsNS41MjIsNC40NzcsMTAsMTAsMTBoODBjNS41MjMsMCwxMC00LjQ3OCwxMC0xMHYtODAgIGMwLTUuNTIyLTQuNDc3LTEwLTEwLTEwaC0zMHYtNTZoMTR2MTBjMCw1LjUyMiw0LjQ3NywxMCwxMCwxMGg3NnYzNmgtMzBjLTUuNTIzLDAtMTAsNC40NzgtMTAsMTB2ODBjMCw1LjUyMiw0LjQ3NywxMCwxMCwxMGg4MCAgYzUuNTIzLDAsMTAtNC40NzgsMTAtMTB2LTgwYzAtNS41MjItNC40NzctMTAtMTAtMTBoLTMwdi0zNmg3NmM1LjUyMywwLDEwLTQuNDc4LDEwLTEwdi0xMGgxNHY1NmgtMzBjLTUuNTIzLDAtMTAsNC40NzgtMTAsMTB2ODAgIGMwLDUuNTIyLDQuNDc3LDEwLDEwLDEwaDgwYzUuNTIzLDAsMTAtNC40NzgsMTAtMTB2LTgwYzAtNS41MjItNC40NzctMTAtMTAtMTBoLTMwdi02NmMwLTUuNTIyLTQuNDc3LTEwLTEwLTEwaC0yNHYtMjIuMDI2aDI0ICBjNS41MjMsMCwxMC00LjQ3OCwxMC0xMHYtNjAuOThjMjIuNzk1LTQuNjQ2LDQwLTI0Ljg0Nyw0MC00OC45OTRjMC0xMS43MTEtNC4wNTgtMjIuNDg2LTEwLjgyNy0zMS4wMTcgIEM0MjEuNzY5LDk2LjE5NCw0MjkuMTY5LDk4LDQzNi45ODUsOThINDY1djE0NC4zMzNjMCw1LjUyMiw0LjQ3NywxMCwxMCwxMHMxMC00LjQ3OCwxMC0xMFY4OCAgQzQ4NSw4NS4yMzcsNDgzLjg3OSw4Mi43MzUsNDgyLjA2Niw4MC45MjV6IE0yMjYsMTI0YzAtMTYuNTQyLDEzLjQ1OC0zMCwzMC0zMHMzMCwxMy40NTgsMzAsMzBzLTEzLjQ1OCwzMC0zMCwzMCAgUzIyNiwxNDAuNTQyLDIyNiwxMjR6IE0xMDYsMTI0YzAtMTYuNTQyLDEzLjQ1OC0zMCwzMC0zMHMzMCwxMy40NTgsMzAsMzBzLTEzLjQ1OCwzMC0zMCwzMFMxMDYsMTQwLjU0MiwxMDYsMTI0eiBNMTY2LDQyMmgtNjB2LTYwICBoNjBWNDIyeiBNMjg2LDQyMmgtNjB2LTYwaDYwVjQyMnogTTQwNiw0MjJoLTYwdi02MGg2MFY0MjJ6IE0zMzIsMjg2SDE4MHYtMTkuODczaDUzLjg1NWM1LjUyMywwLDEwLTQuNDc4LDEwLTEwcy00LjQ3Ny0xMC0xMC0xMCAgSDE4MFYyMjZoMTUyVjI4NnogTTM3NiwxNTRjLTE2LjU0MiwwLTMwLTEzLjQ1OC0zMC0zMHMxMy40NTgtMzAsMzAtMzBzMzAsMTMuNDU4LDMwLDMwUzM5Mi41NDIsMTU0LDM3NiwxNTR6IE00MzYuOTg1LDc4ICBjLTE2LjU0MiwwLTMwLTEzLjQ1OC0zMC0zMFYzNC4xMzlMNDUwLjg1NCw3OEg0MzYuOTg1eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K';
    }
}
