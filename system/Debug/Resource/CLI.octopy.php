@php

use Octopy\Console\Output as CLIOutput;

$command = new CLIOutput;
$output  = $command->output('%y%%S% Type     : %N%' . $title);
        
if ($message !== '') {
    $output .= $command->output('%y%%S% Message  : %N%' . $message);
}

$location = str_replace(BASEPATH, '/', $file);
$output .= $command->output(
    '%y%%S% Location : %N%' . $location . ' #' . $line
);

echo $output;
@endphp