<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PermissionController extends Controller
{
    public function setOwnershipAndPermissions(Request $request)
    {
        $folders = $request->input('folders', [
            'uganda',
            'srilanka',
            'qatar',
            'philippines',
            'ethopia',
            'kuwait',
        ]);

        $basePath = '/www';

        foreach ($folders as $dir) {
            $path = "{$basePath}/{$dir}";
            $this->run("sudo chown -R root:root {$path}");
            $this->run("sudo chmod -R 2777 {$path}");
        }

        $this->run("sudo chown -R root:root {$basePath}");
        $this->run("sudo chmod -R 777 {$basePath}");

        return response()->json(['success' => true]);
    }

    protected function run(string $cmd): void
    {
        $process = Process::fromShellCommandline($cmd);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
