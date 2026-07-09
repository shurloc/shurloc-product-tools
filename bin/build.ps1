param(
    [string]$PluginName = "shurloc-product-tools"
)

$ErrorActionPreference = "Stop"

$ProjectRoot = (Resolve-Path "$PSScriptRoot\..").Path

$BuildRoot  = Join-Path $ProjectRoot "build\dist"
$PluginRoot = Join-Path $BuildRoot $PluginName
$ZipFile    = Join-Path $BuildRoot "$PluginName.zip"

Write-Host ""
Write-Host "Building $PluginName..."
Write-Host ""

#
# Clean previous build.
#
if (Test-Path $PluginRoot) {
    Remove-Item $PluginRoot -Recurse -Force
}

if (Test-Path $ZipFile) {
    Remove-Item $ZipFile -Force
}

New-Item `
    -ItemType Directory `
    -Force `
    -Path $PluginRoot | Out-Null

#
# Copy plugin root PHP files.
#
Copy-Item `
    "$ProjectRoot\*.php" `
    $PluginRoot

#
# Ensure the plugin bootstrap file was copied.
#
if (-not (Test-Path "$PluginRoot\shurloc-product-tools.php")) {
    throw "Plugin bootstrap file 'shurloc-product-tools.php' was not copied."
}

#
# Copy plugin directories.
#
$Directories = @(
    "includes",
    "assets",
    "languages",
    "templates"
)

foreach ($Directory in $Directories) {

    $Source = Join-Path $ProjectRoot $Directory

    if (Test-Path $Source) {

        Copy-Item `
            $Source `
            $PluginRoot `
            -Recurse
    }
}

#
# Ensure the includes directory was copied.
#
if (-not (Test-Path "$PluginRoot\includes")) {
    throw "The 'includes' directory was not copied."
}

#
# Create ZIP archive.
#
Compress-Archive `
    -Path "$PluginRoot\*" `
    -DestinationPath $ZipFile `
    -Force

Write-Host ""
Write-Host "Build complete."
Write-Host ""
Write-Host "Folder:"
Write-Host "  $PluginRoot"
Write-Host ""
Write-Host "ZIP:"
Write-Host "  $ZipFile"
Write-Host ""
