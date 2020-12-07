<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class FilesController
 *
 * @author lacal
 */
class FilesController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth:api', 'scope:admin-user,moderator-user'])->except(['downloadPdf', 'downloadTitleImg', 'downloadImage']);
    }

    /**
     * Uploads pdf file and returns path
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function uploadPdf(Request $request, $id)
    {
        if ($request->has('pdf')) {

            // encoded pdf file
            $encodedPdfFile = $request->input('pdf');
            if (!empty($encodedPdfFile) && $encodedPdfFile != 'null') {

                // decode file from json request
                $file = base64_decode($encodedPdfFile);

                // create path
                $path = 'pdf/' . $id . '/' . Carbon::now()->format('YmdHisu');

                // upload file
                Storage::disk('azure')->put($path, $file);

                // return json with path
                return response()->json([
                    'success' => true,
                    'message' => 'Pdf successfully stored',
                    'path' => $path], 201);
            }
        }

        // return unsuccessful json response
        return response()->json([
            'success' => false,
            'message' => 'Pdf not found'], 404);
    }

    /**
     * Gets pdf according event id and returns it with path
     *
     * @param $id
     * @return JsonResponse
     */
    public function downloadPdf($id)
    {
        // create empty array for pdfs and pdfs paths
        $pdfArr = [];
        $pdfPathArr = [];

        // get file names in event directory to array
        $filesName = Storage::disk('azure')->allFiles('pdf/' . $id);

        $i = 0;

        // run through filenames array
        foreach ($filesName as $fileName) {
            $i++;

            // get file
            $file = Storage::disk('azure')->get($fileName);

            // encode it and push pdf to array
            $pdfArr['pdf' . $i] = base64_encode($file);

            // write pdf path to array
            $pdfPathArr['pdf' . $i . '_path'] = $fileName;
        }

        // if no pdfs exist
        if ($i == 0) {

            // return unsuccessful json response
            return response()->json([
                'success' => false,
                'message' => 'Pdf not found'], 404);
        } else {

            // return successful json response with pdfs and paths
            return response()->json([
                'success' => true,
                'message' => 'Pdf successfully returned',
                'pdfs_path' => $pdfPathArr,
                'pdfs' => $pdfArr], 200);
        }
    }

    /**
     * Removes pdf from event
     *
     * @param $id
     * @return JsonResponse
     */
    public function deletePdf($id)
    {

        // get array of directories in pdf
        $array = Storage::disk('azure')->allDirectories('pdf');

        // check if directory exists
        if (in_array('pdf/' . $id, $array)) {

            // delete pdf directory of the event
            Storage::disk('azure')->deleteDirectory('pdf/' . $id);

            // return successful json response
            return response()->json([
                'success' => true,
                'message' => 'Pdf successfully removed'], 200);
        }

        // return successful json response
        return response()->json([
            'success' => false,
            'message' => 'Pdf directory doesnt exists: pdf/' . $id], 404);
    }

    /**
     * Uploads title image and returns path
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function uploadTitleImg(Request $request, $id)
    {
        if ($request->has('title_image')) {

            // encoded title image file
            $encodedTitleImageFile = $request->input('title_image');
            if (!empty($encodedTitleImageFile) && $encodedTitleImageFile != 'null') {

                // decode file from json request
                $file = base64_decode($encodedTitleImageFile);

                // create path
                $path = 'titleImg/' . $id . '/' . Carbon::now()->format('YmdHisu');

                // upload title image
                Storage::disk('azure')->put($path, $file);

                // return json with path
                return response()->json([
                    'success' => true,
                    'message' => 'Title image successfully stored',
                    'path' => $path], 201);
            }
        }

        // return unsuccessful json response
        return response()->json([
            'success' => false,
            'message' => 'Title image not found'], 404);
    }

    /**
     * Gets title image according event id and returns it with path
     *
     * @param $id
     * @return JsonResponse
     */
    public function downloadTitleImg($id)
    {
        // create empty array for title image paths
        // $titleImgArr = [];
        $titleImgPathArr = [];

        // get file names in event directory to array
        $filesName = Storage::disk('azure')->allFiles('titleImg/' . $id);

        $i = 0;

        // run through filenames array
        foreach ($filesName as $fileName) {
            $i++;

            // get image
            // $file = Storage::disk('azure')->get($fileName);

            // encode it and push it to array
            // $titleImgArr['title_image' . $i] = base64_encode($file);

            // write title image path to array
            $titleImgPathArr['title_image' . $i . '_path'] = $fileName;
        }

        // if no title image exists
        if ($i == 0) {

            // return unsuccessful json response with path
            return response()->json([
                'success' => false,
                'message' => 'Title image not found'], 404);
        } else {

            // return successful json response with path
            return response()->json([
                'success' => true,
                'message' => 'Title image returned successfully',
                'title_images_path' => $titleImgPathArr], 200);
        }
    }

    /**
     * Removes title image from event
     *
     * @param $id
     * @return JsonResponse
     */
    public function deleteTitleImg($id)
    {

        // get array of directories in pdf
        $array = Storage::disk('azure')->allDirectories('titleImg');

        // check if directory exists
        if (in_array('titleImg/' . $id, $array)) {

            // delete title image directory of the event
            Storage::disk('azure')->deleteDirectory('titleImg/' . $id);

            // return successful json response
            return response()->json([
                'success' => true,
                'message' => 'Title image successfully removed'], 200);
        }

        // return successful json response
        return response()->json([
            'success' => false,
            'message' => 'Title image directory doesnt exists: titleImg/' . $id], 404);
    }

    /**
     * Uploads image and returns path
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function uploadImage(Request $request, $id)
    {
        if ($request->has('image')) {

            // encoded image file
            $encodedImageFile = $request->input('image');
            if (!empty($encodedImageFile) && $encodedImageFile != 'null') {

                // decode file from json request
                $file = base64_decode($encodedImageFile);

                // create path
                $path = 'images/' . $id . '/' . Carbon::now()->format('YmdHisu') . '.jpg';

                // upload file
                Storage::disk('azure')->put($path, $file);

                // return json with path
                return response()->json([
                    'success' => true,
                    'message' => 'Image successfully stored',
                    'path' => $path], 201);
            }
        }

        // return unsuccessful json response
        return response()->json([
            'success' => false,
            'message' => 'Image not found'], 404);
    }

    /**
     * Gets images according event id and returns them with paths
     *
     * @param $id
     * @return JsonResponse
     */
    public function downloadImage($id)
    {
        // create empty array for images paths
        // $imageArr = [];
        $imagePathArr = [];

        // get file names in event directory to array
        $filesName = Storage::disk('azure')->allFiles('images/' . $id);

        $i = 0;

        // run through filenames array
        foreach ($filesName as $fileName) {
            $i++;

            // get image
            // $file = Storage::disk('azure')->get($fileName);

            // encode it and push it to array
            // $imageArr['image' . $i] = base64_encode($file);

            // write image path to array
            $imagePathArr['image' . $i . '_path'] = $fileName;
        }

        // if no title image exists
        if ($i == 0) {

            // return unsuccessful json response with path
            return response()->json([
                'success' => false,
                'message' => 'No image found'], 404);
        } else {

            // return successful json response with path
            return response()->json([
                'success' => true,
                'message' => 'Images successfully returned',
                'images_path' => $imagePathArr], 200);
        }
    }

    /**
     * Removes image from event according file name
     *
     * @param $id
     * @param $imageName
     * @return JsonResponse
     */
    public function deleteImage($id, $imageName)
    {
        if (Storage::disk('azure')->exists('images/' . $id . '/' . $imageName . '.jpg')) {

            // delete title image file of the event with thumbnail
            Storage::disk('azure')->delete('images/' . $id . '/' . $imageName . '.jpg');
            Storage::disk('azure')->delete('thumb-images/' . $id . '/' . $imageName . '.jpg');

            // return successful json response
            return response()->json([
                'success' => true,
                'message' => 'Image successfully removed'], 200);
        }

        // return successful json response
        return response()->json([
            'success' => false,
            'message' => 'Image file doesnt exists: images/' . $id . '/' . $imageName . '.jpg'], 404);
    }

    /**
     * Removes all images from event
     *
     * @param $id
     * @return JsonResponse
     */
    public function deleteAllImages($id)
    {

        // get array of directories in pdf
        $array = Storage::disk('azure')->allDirectories('images');

        // check if directory exists
        if (in_array('images/' . $id, $array)) {

            // delete title image directory of the event with thumbnails
            Storage::disk('azure')->deleteDirectory('images/' . $id);
            Storage::disk('azure')->deleteDirectory('thumb-images/' . $id);

            // return successful json response
            return response()->json([
                'success' => true,
                'message' => 'Images successfully removed'], 200);
        }

        // return successful json response
        return response()->json([
            'success' => false,
            'message' => 'Images directory doesnt exists: images/' . $id], 404);
    }
}
