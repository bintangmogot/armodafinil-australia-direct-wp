$files = Get-ChildItem -Path . -Filter * -Recurse | Where-Object { $_.Extension -match "\.(php|css)$" -and -not $_.PSIsContainer }
foreach ($file in $files) {
    $bytes = [System.IO.File]::ReadAllBytes($file.FullName)
    if ($bytes.Length -ge 3 -and $bytes[0] -eq 0xEF -and $bytes[1] -eq 0xBB -and $bytes[2] -eq 0xBF) {
        Write-Host "Found BOM in $($file.Name). Removing..."
        $content = [System.IO.File]::ReadAllText($file.FullName)
        [System.IO.File]::WriteAllText($file.FullName, $content, (New-Object System.Text.UTF8Encoding($False)))
    }
}