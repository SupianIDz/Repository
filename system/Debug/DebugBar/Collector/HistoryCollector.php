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

class HistoryCollector
{
    /**
     * @var string
     */
    public $title = 'History';

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
        return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ4MCA0ODAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4MCA0ODA7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPjxnIHRyYW5zZm9ybT0ibWF0cml4KDAuOTUwODk1LCAwLCAwLCAwLjk1MDg5NSwgMTEuNzg1MiwgMTEuNzg1MikiPjxjaXJjbGUgc3R5bGU9ImZpbGw6I0U2RTdFODsiIGN4PSIyNDAiIGN5PSI2NCIgcj0iMTYiIGRhdGEtb3JpZ2luYWw9IiNFNkU3RTgiLz48cGF0aCBzdHlsZT0iZmlsbDojNzI2NjU4OyIgZD0iTTQyNCw1NmgtODB2MzJoNDh2MzUySDg4Vjg4aDQ4VjU2SDU2djQxNmgzNjhWNTZ6IiBkYXRhLW9yaWdpbmFsPSIjNzI2NjU4Ii8+PHBhdGggc3R5bGU9ImZpbGw6I0ZGRjdEODsiIGQ9Ik0xMzYsMTA0Vjg4SDg4djM1MmgzMDRWODhoLTQ4djE2SDEzNnogTTI0MCwxNTJjMzAuOTI4LDAsNTYsMjUuMDcyLDU2LDU2cy0yNS4wNzIsNTYtNTYsNTYgIHMtNTYtMjUuMDcyLTU2LTU2UzIwOS4wNzIsMTUyLDI0MCwxNTJ6IiBkYXRhLW9yaWdpbmFsPSIjRkZGN0Q4Ii8+PHBhdGggc3R5bGU9ImZpbGw6IzM5QjU0QTsiIGQ9Ik0yNDAsMjY0YzMwLjkyOCwwLDU2LTI1LjA3Miw1Ni01NnMtMjUuMDcyLTU2LTU2LTU2cy01NiwyNS4wNzItNTYsNTZTMjA5LjA3MiwyNjQsMjQwLDI2NHogTTIzMiwyMjQgIGwzMy45NDQtMzMuOTQ0TDIzMiwyMjRsLTIyLjYyNC0yMi42MjRMMjMyLDIyNHoiIGRhdGEtb3JpZ2luYWw9IiMzOUI1NEEiLz48cGF0aCBzdHlsZT0iZmlsbDojQzQ5QTZDOyIgZD0iTTEzNiwxMDRoMjA4VjU2Yy0wLjAyNi04LjgyNi03LjE3NC0xNS45NzQtMTYtMTZoLTQ4YzAuMDIyLTE3LjY1MS0xNC4yNjktMzEuOTc4LTMxLjkyLTMyICBjLTAuMDI3LDAtMC4wNTMsMC0wLjA4LDBoLTE2Yy0xNy42NzMsMC0zMiwxNC4zMjctMzIsMzJoLTQ4Yy04LjgyNiwwLjAyNi0xNS45NzQsNy4xNzQtMTYsMTZWMTA0eiBNMjQwLDQ4YzguODM3LDAsMTYsNy4xNjMsMTYsMTYgIHMtNy4xNjMsMTYtMTYsMTZjLTguODM3LDAtMTYtNy4xNjMtMTYtMTZDMjI0LjAyNiw1NS4xNzQsMjMxLjE3NCw0OC4wMjYsMjQwLDQ4eiIgZGF0YS1vcmlnaW5hbD0iI0M0OUE2QyIvPjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzMUYyMCIgZD0iTTIzMiwyMzUuMzEybC0yOC4yODgtMjguMjg4bDExLjMxMi0xMS4zMTJMMjMyLDIxMi42ODhsMjguMjg4LTI4LjI4OGwxMS4zMTIsMTEuMzEyTDIzMiwyMzUuMzEyeiIgZGF0YS1vcmlnaW5hbD0iIzIzMUYyMCIgY2xhc3M9ImFjdGl2ZS1wYXRoIi8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojMjMxRjIwIiBkPSJNMTY4LDMyMGgtMzJjLTQuNDE4LDAtOC0zLjU4Mi04LThzMy41ODItOCw4LThoMzJjNC40MTgsMCw4LDMuNTgyLDgsOFMxNzIuNDE4LDMyMCwxNjgsMzIweiIgZGF0YS1vcmlnaW5hbD0iIzIzMUYyMCIgY2xhc3M9ImFjdGl2ZS1wYXRoIi8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojMjMxRjIwIiBkPSJNMzQ0LDMyMEgyMDBjLTQuNDE4LDAtOC0zLjU4Mi04LThzMy41ODItOCw4LThoMTQ0YzQuNDE4LDAsOCwzLjU4Miw4LDhTMzQ4LjQxOCwzMjAsMzQ0LDMyMHoiIGRhdGEtb3JpZ2luYWw9IiMyMzFGMjAiIGNsYXNzPSJhY3RpdmUtcGF0aCIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzMUYyMCIgZD0iTTE2OCwzNTJoLTMyYy00LjQxOCwwLTgtMy41ODItOC04czMuNTgyLTgsOC04aDMyYzQuNDE4LDAsOCwzLjU4Miw4LDhTMTcyLjQxOCwzNTIsMTY4LDM1MnoiIGRhdGEtb3JpZ2luYWw9IiMyMzFGMjAiIGNsYXNzPSJhY3RpdmUtcGF0aCIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzMUYyMCIgZD0iTTM0NCwzNTJIMjAwYy00LjQxOCwwLTgtMy41ODItOC04czMuNTgyLTgsOC04aDE0NGM0LjQxOCwwLDgsMy41ODIsOCw4UzM0OC40MTgsMzUyLDM0NCwzNTJ6IiBkYXRhLW9yaWdpbmFsPSIjMjMxRjIwIiBjbGFzcz0iYWN0aXZlLXBhdGgiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMyMzFGMjAiIGQ9Ik0xNjgsMzg0aC0zMmMtNC40MTgsMC04LTMuNTgyLTgtOHMzLjU4Mi04LDgtOGgzMmM0LjQxOCwwLDgsMy41ODIsOCw4UzE3Mi40MTgsMzg0LDE2OCwzODR6IiBkYXRhLW9yaWdpbmFsPSIjMjMxRjIwIiBjbGFzcz0iYWN0aXZlLXBhdGgiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMyMzFGMjAiIGQ9Ik0zNDQsMzg0SDIwMGMtNC40MTgsMC04LTMuNTgyLTgtOHMzLjU4Mi04LDgtOGgxNDRjNC40MTgsMCw4LDMuNTgyLDgsOFMzNDguNDE4LDM4NCwzNDQsMzg0eiIgZGF0YS1vcmlnaW5hbD0iIzIzMUYyMCIgY2xhc3M9ImFjdGl2ZS1wYXRoIi8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojMjMxRjIwIiBkPSJNMjQwLDI3MmMtMzUuMzQ2LDAtNjQtMjguNjU0LTY0LTY0czI4LjY1NC02NCw2NC02NHM2NCwyOC42NTQsNjQsNjQgICBDMzAzLjk2LDI0My4zMywyNzUuMzMsMjcxLjk2LDI0MCwyNzJ6IE0yNDAsMTYwYy0yNi41MSwwLTQ4LDIxLjQ5LTQ4LDQ4czIxLjQ5LDQ4LDQ4LDQ4czQ4LTIxLjQ5LDQ4LTQ4ICAgQzI4Ny45NzQsMTgxLjUwMSwyNjYuNDk5LDE2MC4wMjYsMjQwLDE2MHoiIGRhdGEtb3JpZ2luYWw9IiMyMzFGMjAiIGNsYXNzPSJhY3RpdmUtcGF0aCIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzMUYyMCIgZD0iTTQyNCw0OGgtNzMuNDcyQzM0Ny4xNSwzOC40NDUsMzM4LjEzNCwzMi4wNDIsMzI4LDMyaC00MC44QzI4My40MTgsMTMuMzYxLDI2Ny4wMTktMC4wMjYsMjQ4LDBoLTE2ICAgYy0xOS4wMDIsMC4wMjEtMzUuMzc1LDEzLjM4Ny0zOS4yLDMySDE1MmMtMTAuMTM0LDAuMDQyLTE5LjE1LDYuNDQ1LTIyLjUyOCwxNkg1NmMtNC40MTgsMC04LDMuNTgyLTgsOHY0MTZjMCw0LjQxOCwzLjU4Miw4LDgsOCAgIGgzNjhjNC40MTgsMCw4LTMuNTgyLDgtOFY1NkM0MzIsNTEuNTgyLDQyOC40MTgsNDgsNDI0LDQ4eiBNMTM2LDExMmgyMDhjNC40MTgsMCw4LTMuNTgyLDgtOHYtOGgzMnYzMzZIOTZWOTZoMzJ2OCAgIEMxMjgsMTA4LjQxOCwxMzEuNTgyLDExMiwxMzYsMTEyeiBNMTUyLDQ4aDQ4YzQuNDE4LDAsOC0zLjU4Miw4LThjMC0xMy4yNTUsMTAuNzQ1LTI0LDI0LTI0aDE2ICAgYzEzLjIyOC0wLjAyNywyMy45NzMsMTAuNjc2LDI0LDIzLjkwNGMwLDAuMDMyLDAsMC4wNjQsMCwwLjA5NmMwLDQuNDE4LDMuNTgyLDgsOCw4aDQ4YzQuNDE4LDAsOCwzLjU4Miw4LDh2NDBIMTQ0VjU2ICAgQzE0NCw1MS41ODIsMTQ3LjU4Miw0OCwxNTIsNDh6IE00MTYsNDY0SDY0VjY0aDY0djE2SDg4Yy00LjQxOCwwLTgsMy41ODItOCw4djM1MmMwLDQuNDE4LDMuNTgyLDgsOCw4aDMwNGM0LjQxOCwwLDgtMy41ODIsOC04Vjg4ICAgYzAtNC40MTgtMy41ODItOC04LThoLTQwVjY0aDY0VjQ2NHoiIGRhdGEtb3JpZ2luYWw9IiMyMzFGMjAiIGNsYXNzPSJhY3RpdmUtcGF0aCIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzMUYyMCIgZD0iTTI0MCw4OGMxMy4yNTUsMCwyNC0xMC43NDUsMjQtMjRzLTEwLjc0NS0yNC0yNC0yNGMtMTMuMjU1LDAtMjQsMTAuNzQ1LTI0LDI0UzIyNi43NDUsODgsMjQwLDg4eiAgICBNMjQwLDU2YzQuNDE4LDAsOCwzLjU4Miw4LDhzLTMuNTgyLDgtOCw4cy04LTMuNTgyLTgtOFMyMzUuNTgyLDU2LDI0MCw1NnoiIGRhdGEtb3JpZ2luYWw9IiMyMzFGMjAiIGNsYXNzPSJhY3RpdmUtcGF0aCIvPgo8L2c+PHNjcmlwdCB4bWxucz0iIj4KICB7CiAgICBjb25zdCBvcGVuID0gWE1MSHR0cFJlcXVlc3QucHJvdG90eXBlLm9wZW47CiAgICBYTUxIdHRwUmVxdWVzdC5wcm90b3R5cGUub3BlbiA9IGZ1bmN0aW9uIChtZXRob2QsIHVybCkgewogICAgICBvcGVuLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7CiAgICAgIHRoaXMuYWRkRXZlbnRMaXN0ZW5lcigncmVhZHlzdGF0ZWNoYW5nZScsIGZ1bmN0aW9uIF8oKSB7CiAgICAgICAgaWYodGhpcy5yZWFkeVN0YXRlID09IHRoaXMuSEVBREVSU19SRUNFSVZFRCkgewogICAgICAgICAgY29uc3QgY29udGVudFR5cGUgPSB0aGlzLmdldFJlc3BvbnNlSGVhZGVyKCdDb250ZW50LVR5cGUnKSB8fCAnJzsKICAgICAgICAgIGlmIChjb250ZW50VHlwZS5zdGFydHNXaXRoKCd2aWRlby8nKSB8fCBjb250ZW50VHlwZS5zdGFydHNXaXRoKCdhdWRpby8nKSkgewogICAgICAgICAgICB3aW5kb3cucG9zdE1lc3NhZ2UoewogICAgICAgICAgICAgIHNvdXJjZTogJ3htbGh0dHByZXF1ZXN0LW9wZW4nLAogICAgICAgICAgICAgIHVybCwKICAgICAgICAgICAgICBtaW1lOiBjb250ZW50VHlwZSwKICAgICAgICAgICAgICBtZXRob2QsCiAgICAgICAgICAgICAgY29udGVudFR5cGUKICAgICAgICAgICAgfSwgJyonKTsKICAgICAgICAgIH0KICAgICAgICAgIHRoaXMucmVtb3ZlRXZlbnRMaXN0ZW5lcigncmVhZHlzdGF0ZWNoYW5nZScsIF8pOwogICAgICAgIH0KICAgICAgfSkKICAgIH0KICB9CiAgPC9zY3JpcHQ+PC9nPiA8L3N2Zz4K';
    }
}