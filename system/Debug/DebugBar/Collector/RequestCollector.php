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

use Octopy\Support\Request;
use Octopy\Support\Response;

class RequestCollector
{
    /**
     * @var string
     */
    public $title = 'Request';

    /**
     * @return Request
     */
    public function collect() : array
    {
        return [
            'ajax'   => Request::ajax(),
            'data'   => Request::all(),
            'header' => Request::headers(),
            'server' => Request::server(),
            'response' => [
                'status' => Response::status(),
                'header' => Response::headers()
            ]
        ];
    }

    /**
     * @return string
     */
    public function icon() : string
    {
        return 'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8cGF0aCBzdHlsZT0iZmlsbDojRkZGRkZGOyIgZD0iTTc2LjE2MiwzODRINDIuMDE1Yy0xNy42NzMsMC0zMi0xNC4zMjctMzItMzJWNDJjMC0xNy42NzMsMTQuMzI3LTMyLDMyLTMyaDM4OCAgYzE3LjY3MywwLDMyLDE0LjMyNywzMiwzMnYzMTBjMCwxNy42NzMtMTQuMzI3LDMyLTMyLDMySDM4Ny42SDc2LjE2MnoiLz4KPHBhdGggc3R5bGU9ImZpbGw6I0ZGNUE1QTsiIGQ9Ik00MzAuMDE1LDEwaC0zODhjLTE3LjY3MywwLTMyLDE0LjMyNy0zMiwzMnY0MGg0NTJWNDJDNDYyLjAxNSwyNC4zMjcsNDQ3LjY4OCwxMCw0MzAuMDE1LDEweiIvPgo8cGF0aCBzdHlsZT0iZmlsbDojMjMxRjIwOyIgZD0iTTIwLjEyNSw4Mmg0MzYuODkxIi8+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6I0Y1Qjk1NTsiIGQ9Ik00ODQuNDc5LDM3OWMwLTYuNzYtMC42NTktMTMuMzY1LTEuOTAxLTE5Ljc2MWwxOS40MDctMTcuNTNsLTI4LTQ4LjQxM2wtMjQuODU5LDguMDMzICAgYy05LjkxNy04LjY0NS0yMS41MDUtMTUuNDItMzQuMjE2LTE5Ljc4TDQwOS40MzcsMjU2aC01NS45MjNsLTUuNDczLDI1LjU0OGMtMTIuNzExLDQuMzYtMjQuMjk5LDExLjEzNS0zNC4yMTYsMTkuNzggICBsLTI0Ljg1OS04LjAzM2wtMjgsNDguNDEzbDE5LjQwNywxNy41M2MtMS4yNDMsNi4zOTYtMS45MDIsMTMuMDAxLTEuOTAyLDE5Ljc2MXMwLjY1OCwxMy4zNjUsMS45MDIsMTkuNzYxbC0xOS40MDcsMTcuNTMgICBsMjgsNDguNDE0bDI0Ljg1OS04LjAzM2M5LjkxNyw4LjY0NSwyMS41MDUsMTUuNDIsMzQuMjE2LDE5Ljc4TDM1My41MTQsNTAyaDU1LjkyM2w1LjQ3My0yNS41NDggICBjMTIuNzExLTQuMzYsMjQuMjk4LTExLjEzNSwzNC4yMTYtMTkuNzhsMjQuODU5LDguMDMzbDI4LTQ4LjQxNGwtMTkuNDA3LTE3LjUzQzQ4My44MjEsMzkyLjM2NSw0ODQuNDc5LDM4NS43Niw0ODQuNDc5LDM3OXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGRkZGRkY7IiBkPSJNMzgxLjQ3NSw0MzQuMzMzYy0zMC41NiwwLTU1LjMzMy0yNC43NzQtNTUuMzMzLTU1LjMzM3MyNC43NzQtNTUuMzMzLDU1LjMzMy01NS4zMzMgICBTNDM2LjgwOSwzNDguNDQsNDM2LjgwOSwzNzlTNDEyLjAzNSw0MzQuMzMzLDM4MS40NzUsNDM0LjMzM3oiLz4KPC9nPgo8cGF0aCBkPSJNMjA0LjgzOSw1NmgyMDAuMTc2YzUuNTIzLDAsMTAtNC40NzcsMTAtMTBzLTQuNDc3LTEwLTEwLTEwSDIwNC44MzljLTUuNTIzLDAtMTAsNC40NzctMTAsMTBTMTk5LjMxNiw1NiwyMDQuODM5LDU2eiIvPgo8cGF0aCBkPSJNOTYuMzc1LDU2YzIuNjMsMCw1LjIxLTEuMDcsNy4wNy0yLjkzczIuOTMtNC40NCwyLjkzLTcuMDdzLTEuMDctNS4yMS0yLjkzLTcuMDdTOTkuMDA1LDM2LDk2LjM3NSwzNiAgYy0yLjY0LDAtNS4yMSwxLjA3LTcuMDcsMi45M3MtMi45Myw0LjQ0LTIuOTMsNy4wN3MxLjA3LDUuMjEsMi45Myw3LjA3UzkzLjczNSw1Niw5Ni4zNzUsNTZ6Ii8+CjxwYXRoIGQ9Ik01OS42MjUsNTZjMi42MywwLDUuMjEtMS4wNyw3LjA3LTIuOTNzMi45My00LjQ0LDIuOTMtNy4wN3MtMS4wNy01LjIxLTIuOTMtNy4wN1M2Mi4yNTUsMzYsNTkuNjI1LDM2cy01LjIxLDEuMDctNy4wNywyLjkzICBzLTIuOTMsNC40NC0yLjkzLDcuMDdzMS4wNyw1LjIxLDIuOTMsNy4wN1M1Ni45OTUsNTYsNTkuNjI1LDU2eiIvPgo8cGF0aCBkPSJNMTMzLjEyNSw1NmMyLjYzLDAsNS4yMS0xLjA3LDcuMDctMi45M3MyLjkzLTQuNDQsMi45My03LjA3cy0xLjA3LTUuMjEtMi45My03LjA3Yy0xLjg2LTEuODYtNC40NC0yLjkzLTcuMDctMi45MyAgYy0yLjY0LDAtNS4yMSwxLjA3LTcuMDgsMi45M2MtMS44NiwxLjg2LTIuOTIsNC40NC0yLjkyLDcuMDdzMS4wNiw1LjIxLDIuOTIsNy4wN0MxMjcuOTE1LDU0LjkzLDEzMC40ODUsNTYsMTMzLjEyNSw1NnoiLz4KPHBhdGggZD0iTTc5LjY5NywyMjguODMzYzAuMDUsMCwwLjEwMSwwLDAuMTUxLTAuMDAxYzMuNzkxLTAuMDU3LDcuMjIzLTIuMjUyLDguODY0LTUuNjdsMTYuMjk1LTMzLjkyOWwxNy43MDIsMzQuMTk3ICBjMS43NDMsMy4zNjYsNS4yMDUsNS40MjgsOS4wMzEsNS40MDJjMy43OTEtMC4wNTcsNy4yMjMtMi4yNTIsOC44NjQtNS42N2wyNC45NzQtNTJjMi4zOTEtNC45NzksMC4yOTMtMTAuOTUzLTQuNjg1LTEzLjM0MyAgYy00Ljk3Ny0yLjM5Mi0xMC45NTItMC4yOTMtMTMuMzQzLDQuNjg1bC0xNi4yOTUsMzMuOTI5bC0xNy43MDItMzQuMTk3Yy0xLjc0NC0zLjM2Ny01LjIyLTUuNDM1LTkuMDMxLTUuNDAyICBjLTMuNzkxLDAuMDU3LTcuMjIzLDIuMjUyLTguODY0LDUuNjdsLTE2LjI5NSwzMy45MjlMNjEuNjYsMTYyLjIzNmMtMi41MzktNC45MDQtOC41NzEtNi44MjItMTMuNDc4LTQuMjg0ICBjLTQuOTA1LDIuNTM5LTYuODIyLDguNTczLTQuMjg0LDEzLjQ3OGwyNi45MTgsNTJDNzIuNTM3LDIyNi43NTMsNzUuOTY0LDIyOC44MzMsNzkuNjk3LDIyOC44MzN6Ii8+CjxwYXRoIGQ9Ik0yNjIuOTMzLDIyOC44MzNjMC4wNSwwLDAuMTAxLDAsMC4xNTEtMC4wMDFjMy43OTEtMC4wNTcsNy4yMjMtMi4yNTIsOC44NjQtNS42N2wyNC45NzQtNTIgIGMyLjM5MS00Ljk3OSwwLjI5My0xMC45NTMtNC42ODUtMTMuMzQzYy00Ljk3OC0yLjM5Mi0xMC45NTMtMC4yOTQtMTMuMzQzLDQuNjg1bC0xNi4yOTUsMzMuOTI5bC0xNy43MDItMzQuMTk3ICBjLTEuNzQzLTMuMzY3LTUuMjYxLTUuNDMtOS4wMzEtNS40MDJjLTMuNzkxLDAuMDU3LTcuMjIzLDIuMjUyLTguODY0LDUuNjdsLTE2LjI5NSwzMy45MjlsLTE3LjcwMi0zNC4xOTcgIGMtMi41MzktNC45MDQtOC41NzItNi44MjItMTMuNDc4LTQuMjg0Yy00LjkwNSwyLjUzOS02LjgyMiw4LjU3My00LjI4NCwxMy40NzhsMjYuOTE4LDUyYzEuNzQzLDMuMzY3LDUuMjY3LDUuNDMxLDkuMDMxLDUuNDAyICBjMy43OTEtMC4wNTcsNy4yMjMtMi4yNTIsOC44NjQtNS42N2wxNi4yOTUtMzMuOTI5bDE3LjcwMiwzNC4xOTdDMjU1Ljc3MywyMjYuNzUzLDI1OS4yLDIyOC44MzMsMjYyLjkzMywyMjguODMzeiIvPgo8cGF0aCBkPSJNNDEwLjIzNywxNjIuNTA0bC0xNi4yOTUsMzMuOTI5bC0xNy43MDItMzQuMTk3Yy0xLjc0My0zLjM2Ny01LjIzOC01LjQzLTkuMDMxLTUuNDAyYy0zLjc5MSwwLjA1Ny03LjIyMywyLjI1Mi04Ljg2NCw1LjY3ICBsLTE2LjI5NSwzMy45MjlsLTE3LjcwMi0zNC4xOTdjLTIuNTM5LTQuOTA0LTguNTcxLTYuODIyLTEzLjQ3OC00LjI4NGMtNC45MDUsMi41MzktNi44MjIsOC41NzMtNC4yODQsMTMuNDc4bDI2LjkxOCw1MiAgYzEuNzQzLDMuMzY3LDUuMjUyLDUuNDMxLDkuMDMxLDUuNDAyYzMuNzkxLTAuMDU3LDcuMjIzLTIuMjUyLDguODY0LTUuNjdsMTYuMjk1LTMzLjkyOWwxNy43MDIsMzQuMTk3ICBjMS43MiwzLjMyMiw1LjE0Nyw1LjQwMyw4Ljg4LDUuNDAzYzAuMDUsMCwwLjEwMSwwLDAuMTUxLTAuMDAxYzMuNzkxLTAuMDU3LDcuMjIzLTIuMjUyLDguODY0LTUuNjdsMjQuOTc0LTUyICBjMi4zOTEtNC45NzksMC4yOTMtMTAuOTUzLTQuNjg1LTEzLjM0M0M0MTguNjAzLDE1NS40MjcsNDEyLjYyOCwxNTcuNTI1LDQxMC4yMzcsMTYyLjUwNHoiLz4KPHBhdGggZD0iTTQ2Mi4wMTUsMjI1Yy0yLjYzLDAtNS4yMSwxLjA3LTcuMDcsMi45M2MtMS44NiwxLjg2LTIuOTMsNC40NC0yLjkzLDcuMDdzMS4wNyw1LjIxLDIuOTMsNy4wN3M0LjQ0LDIuOTMsNy4wNywyLjkzICBzNS4yMS0xLjA3LDcuMDctMi45M3MyLjkzLTQuNDQsMi45My03LjA3cy0xLjA3LTUuMjEtMi45My03LjA3QzQ2Ny4yMjUsMjI2LjA3LDQ2NC42NDUsMjI1LDQ2Mi4wMTUsMjI1eiIvPgo8cGF0aCBkPSJNMjM4LjU3LDM3NEg0Mi4wMTVjLTEyLjEzMSwwLTIyLTkuODY5LTIyLTIyVjkxLjk5NWMwLjAzNywwLDAuMDczLDAuMDA1LDAuMTA5LDAuMDA1aDQzMS44OTF2MTAwLjgzMyAgYzAsNS41MjMsNC40NzcsMTAsMTAsMTBzMTAtNC40NzcsMTAtMTBWNDJjMC0yMy4xNTktMTguODQxLTQyLTQyLTQyaC0zODhjLTIzLjE1OSwwLTQyLDE4Ljg0MS00Miw0MnYzMTBjMCwyMy4xNTksMTguODQxLDQyLDQyLDQyICBIMjM4LjU3YzUuNTIzLDAsMTAtNC40NzcsMTAtMTBTMjQ0LjA5MywzNzQsMjM4LjU3LDM3NHogTTQyLjAxNSwyMGgzODhjMTIuMTMxLDAsMjIsOS44NjksMjIsMjJ2MzBIMjAuMTI1ICBjLTAuMDM3LDAtMC4wNzMsMC4wMDUtMC4xMDksMC4wMDVWNDJDMjAuMDE1LDI5Ljg2OSwyOS44ODQsMjAsNDIuMDE1LDIweiIvPgo8cGF0aCBkPSJNNTIuNzc5LDMzNC4wMTFoMTE3LjE3N2M1LjUyMywwLDEwLTQuNDc3LDEwLTEwcy00LjQ3Ny0xMC0xMC0xMEg1Mi43NzljLTUuNTIzLDAtMTAsNC40NzctMTAsMTAgIFM0Ny4yNTYsMzM0LjAxMSw1Mi43NzksMzM0LjAxMXoiLz4KPHBhdGggZD0iTTIzMi4wMTUsMjg2LjAxMmM1LjUyMiwwLDkuOTk5LTQuNDc2LDEwLTkuOTk4YzAuMDAxLTUuNTIzLTQuNDc2LTEwLjAwMS05Ljk5OC0xMC4wMDJsLTEzOC4zMzMtMC4wMjUgIGMtMC4wMDEsMC0wLjAwMSwwLTAuMDAxLDBjLTUuNTIyLDAtMTAsNC40NzYtMTAsOS45OThjLTAuMDAxLDUuNTIzLDQuNDc1LDEwLjAwMSw5Ljk5OCwxMC4wMDJMMjMyLjAxNSwyODYuMDEyTDIzMi4wMTUsMjg2LjAxMnoiLz4KPHBhdGggZD0iTTQ1LjcwNSwyODMuMDhjMS44NywxLjg3LDQuNDQsMi45Myw3LjA3LDIuOTNzNS4yMS0xLjA2LDcuMDgtMi45M2MxLjg2LTEuODYsMi45My00LjQ0LDIuOTMtNy4wN3MtMS4wNy01LjIxLTIuOTMtNy4wNyAgYy0xLjg3LTEuODYtNC40NC0yLjkzLTcuMDgtMi45M2MtMi42MywwLTUuMjEsMS4wNy03LjA3LDIuOTNzLTIuOTMsNC40NC0yLjkzLDcuMDdDNDIuNzc1LDI3OC42NSw0My44NDUsMjgxLjIyLDQ1LjcwNSwyODMuMDh6Ii8+CjxwYXRoIGQ9Ik0zODEuNDc1LDMxMy42NjdjLTM2LjAyNSwwLTY1LjMzMywyOS4zMDktNjUuMzMzLDY1LjMzM3MyOS4zMDksNjUuMzMzLDY1LjMzMyw2NS4zMzNzNjUuMzMzLTI5LjMwOSw2NS4zMzMtNjUuMzMzICBTNDE3LjUsMzEzLjY2NywzODEuNDc1LDMxMy42Njd6IE0zODEuNDc1LDQyNC4zMzNjLTI0Ljk5NywwLTQ1LjMzMy0yMC4zMzYtNDUuMzMzLTQ1LjMzM3MyMC4zMzYtNDUuMzMzLDQ1LjMzMy00NS4zMzMgIHM0NS4zMzMsMjAuMzM2LDQ1LjMzMyw0NS4zMzNTNDA2LjQ3Miw0MjQuMzMzLDM4MS40NzUsNDI0LjMzM3oiLz4KPHBhdGggZD0iTTUwOC42ODgsNDA4Ljg3MWwtMTUuMzQzLTEzLjg1OWMwLjc1My01LjMsMS4xMzQtMTAuNjY0LDEuMTM0LTE2LjAxMnMtMC4zODEtMTAuNzEyLTEuMTM0LTE2LjAxMmwxNS4zNDMtMTMuODU5ICBjMy41MDEtMy4xNjMsNC4zMTUtOC4zNDMsMS45NTMtMTIuNDI3bC0yOC00OC40MTRjLTIuMzYtNC4wOC03LjI0OC01Ljk1OC0xMS43MzEtNC41MDlsLTE5LjYzNSw2LjM0NiAgYy04LjQ3LTYuNjY4LTE3Ljc2MS0xMi4wNDEtMjcuNzM1LTE2LjAzNmwtNC4zMjQtMjAuMTg0Yy0wLjk4OC00LjYxMS01LjA2My03LjkwNS05Ljc3OC03LjkwNWgtNTUuOTIzICBjLTQuNzE2LDAtOC43OTEsMy4yOTQtOS43NzgsNy45MDVsLTQuMzIzLDIwLjE4NGMtOS45NzQsMy45OTUtMTkuMjY2LDkuMzY3LTI3LjczNSwxNi4wMzVsLTE5LjYzNi02LjM0NSAgYy00LjQ4NS0xLjQ0OS05LjM3MiwwLjQzLTExLjczMSw0LjUwOWwtMjgsNDguNDE0Yy0yLjM2Miw0LjA4NC0xLjU0OCw5LjI2NCwxLjk1MywxMi40MjdsMTUuMzQzLDEzLjg1OSAgYy0wLjc1Myw1LjMwMS0xLjEzNCwxMC42NjUtMS4xMzQsMTYuMDEyczAuMzgxLDEwLjcxMSwxLjEzNCwxNi4wMTJsLTE1LjM0MywxMy44NTljLTMuNTAxLDMuMTYzLTQuMzE1LDguMzQzLTEuOTUzLDEyLjQyNyAgbDI4LDQ4LjQxNGMyLjM2LDQuMDgsNy4yNDYsNS45NTksMTEuNzMxLDQuNTA5bDE5LjYzNi02LjM0NWM4LjQ2OSw2LjY2OCwxNy43NjEsMTIuMDQsMjcuNzM1LDE2LjAzNWw0LjMyMywyMC4xODQgIGMwLjk4OCw0LjYxMSw1LjA2Myw3LjkwNSw5Ljc3OCw3LjkwNWg1NS45MjNjNC43MTUsMCw4Ljc5MS0zLjI5NCw5Ljc3OC03LjkwNWw0LjMyNC0yMC4xODRjOS45NzQtMy45OTUsMTkuMjY1LTkuMzY3LDI3LjczNS0xNi4wMzYgIGwxOS42MzUsNi4zNDZjNC40ODUsMS40NSw5LjM3Mi0wLjQyOSwxMS43MzEtNC41MDlsMjgtNDguNDE0QzUxMy4wMDMsNDE3LjIxMyw1MTIuMTg5LDQxMi4wMzQsNTA4LjY4OCw0MDguODcxeiBNNDcyLjc2MSwzNjEuMTQ2ICBjMS4xNCw1Ljg2NCwxLjcxOCwxMS44NzEsMS43MTgsMTcuODU0cy0wLjU3OCwxMS45ODktMS43MTgsMTcuODU0Yy0wLjY2OCwzLjQ0LDAuNTEzLDYuOTc5LDMuMTEzLDkuMzI5bDEzLjQwMywxMi4xMDYgIGwtMTkuOTA1LDM0LjQxN2wtMTcuMTcxLTUuNTQ5Yy0zLjM0LTEuMDgtNy0wLjMyOS05LjY0NiwxLjk3OGMtOS4xMTgsNy45NDctMTkuNTEsMTMuOTU2LTMwLjg5LDE3Ljg1OSAgYy0zLjMxOSwxLjEzOC01Ljc5OCwzLjkzMy02LjUzNCw3LjM2NEw0MDEuMzUyLDQ5MmgtMzkuNzUzbC0zLjc3OS0xNy42NDNjLTAuNzM1LTMuNDMxLTMuMjE1LTYuMjI2LTYuNTM0LTcuMzY0ICBjLTExLjM4LTMuOTAzLTIxLjc3My05LjkxMi0zMC44OS0xNy44NTljLTIuNjQ1LTIuMzA3LTYuMzA3LTMuMDU4LTkuNjQ2LTEuOTc4bC0xNy4xNzIsNS41NDlsLTE5LjkwNS0zNC40MTdsMTMuNDAzLTEyLjEwNyAgYzIuNjAxLTIuMzQ5LDMuNzgyLTUuODg5LDMuMTEzLTkuMzI5Yy0xLjE0LTUuODY2LTEuNzE4LTExLjg3My0xLjcxOC0xNy44NTRzMC41NzgtMTEuOTg3LDEuNzE4LTE3Ljg1NCAgYzAuNjY4LTMuNDQtMC41MTMtNi45NzktMy4xMTMtOS4zMjlsLTEzLjQwMy0xMi4xMDdsMTkuOTA1LTM0LjQxN2wxNy4xNzIsNS41NDljMy4zMzgsMS4wOCw3LDAuMzI4LDkuNjQ2LTEuOTc4ICBjOS4xMTctNy45NDcsMTkuNTA5LTEzLjk1NiwzMC44OS0xNy44NTljMy4zMTktMS4xMzksNS43OTgtMy45MzMsNi41MzQtNy4zNjRMMzYxLjU5OSwyNjZoMzkuNzUzbDMuNzc5LDE3LjY0MyAgYzAuNzM1LDMuNDMxLDMuMjE1LDYuMjI2LDYuNTM0LDcuMzY0YzExLjM3OSwzLjkwMywyMS43NzIsOS45MTIsMzAuODksMTcuODU5YzIuNjQ2LDIuMzA2LDYuMzA2LDMuMDU4LDkuNjQ2LDEuOTc4bDE3LjE3MS01LjU0OSAgbDE5LjkwNSwzNC40MTdsLTEzLjQwMywxMi4xMDZDNDczLjI3NCwzNTQuMTY3LDQ3Mi4wOTMsMzU3LjcwNyw0NzIuNzYxLDM2MS4xNDZ6Ii8+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=';
    }
}