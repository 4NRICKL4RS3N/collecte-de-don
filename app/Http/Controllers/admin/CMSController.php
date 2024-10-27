<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Page_element;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    private const BRIGHTNESS_THRESHOLD  = 80; // Adjust this value (0-100)
    private const TARGET_BRIGHTNESS     = 70;
    private const IMAGE_QUALITY         = 60;

    private $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(
            new Driver()
        );
    }

    private function calculateAverageBrightness($image)
    {
        $width = $image->width();
        $height = $image->height();

        $totalBrightness = 0;
        $totalPixels = $width * $height;

        // Sample pixels to calculate average brightness
        for ($x = 0; $x < $width; $x += 2) {
            for ($y = 0; $y < $height; $y += 2) {
                // Get color object in v3
                $color = $image->pickColor($x, $y);
                // Convert RGB to relative luminance using the color object methods
                $brightness = (
                        0.2126 * $color->red()->value() +
                        0.7152 * $color->green()->value() +
                        0.0722 * $color->blue()->value()
                    ) / 2.55;

                $totalBrightness += $brightness;
            }
        }

        // Return average brightness (0-100)
        return $totalBrightness / ($totalPixels / 4);
    }
    public function save(Request $request) {
        $data = $request->all();
        \Log::info("all", [$data]);

        $transformedData = collect($data)->map(function ($value, $key) {
            return [
                'key' => str_replace('_', '.', $key),  // Replace underscores with dots in keys
                'value' => $value
            ];
        })->values();

        $keys = $transformedData->pluck('key')->toArray();

        $pageElements = Page_element::whereIn('key', $keys)->get()->keyBy('key');

        $transformedData->each(function ($element) use ($request, $pageElements) {
            $key = $element['key'];

            if (isset($pageElements[$key])) {
                $page_element = $pageElements[$key];

                if ($page_element->type === 'text') {
                    if ($page_element->content !== $element['value']) {
                        \Log::info("updating", [$page_element]);
                        $page_element->update([
                            'content' => $element['value'],
                        ]);
                    }
                }
                if ($page_element->type === 'image') {
                    \Log::info("page elements", [$page_element]);
                    $file = $request->input(str_replace('.', '_', $key));
                    \Log::info("request", [$request->all()]);
                    \Log::info("page element key", [$key]);
                    \Log::info("page element", [$file]);
                    if ($file) {
                        try {
                            // maka anle sary any amle temp
                            $tempPath = Storage::path($file);
                            $image = $this->manager->read($tempPath);
                            $image->setResolution(72, 72);

                            // manena brightness raha  ohatra ka ambony lotra (jumbotron)
                            if ($key == 'accueil.hero.bgImage') {
                                $brightness = $this->calculateAverageBrightness($image);
                                if ($brightness > self::BRIGHTNESS_THRESHOLD) {
                                    $adjustment = self::TARGET_BRIGHTNESS - $brightness;
                                    $image->brightness($adjustment);
                                }
                            }

                            $filename = basename($file);
                            $processedTempPath = Storage::path('temp/' . uniqid() . '_' . $filename);

                            $encoded = $image->toJpeg(self::IMAGE_QUALITY);
                            file_put_contents($processedTempPath, $encoded);

                            Storage::putFileAs(
                                'public/pages-uploads/',
                                $processedTempPath,
                                $filename
                            );

                            $newPath = 'storage/pages-uploads/' . $filename;
                            $page_element->update([
                                'content' => $newPath,
                            ]);

                            Storage::delete($file);
                            unlink($processedTempPath);
                        } catch (\Exception $e) {
                            \Log::error($e);
                        }
                    }
                }

            }
        });

        return response()->json(['success' => true]);
    }
    public function accueil()
    {
        $accueil = Page::find(3);
        $accueil_element = $accueil->get_page_elements();
        $header_element = Page::find(1)->get_page_elements();
        $footer_element = Page::find(2)->get_page_elements();
        return view('admin.pages.cms_accueil', ['accueil' => $accueil, 'accueil_element' => $accueil_element, 'header_element' => $header_element, 'footer_element' => $footer_element]);
    }
}
