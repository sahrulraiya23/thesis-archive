<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function thesisIndex(Request $request)
    {
        $query = Thesis::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $theses = $query->orderBy('created_at', 'desc')->paginate(12);
        $types = Thesis::getTypes();
        $years = Thesis::selectRaw('DISTINCT year')->orderBy('year', 'desc')->pluck('year');

        return view('public.index', compact('theses', 'types', 'years'));
    }

    public function thesisShow(Thesis $thesis)
    {
        return view('public.show', compact('thesis'));
    }

    public function plagiarismCheck()
    {
        return view('public.plagiarism');
    }

    public function checkPlagiarism(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $inputTitle = strtolower(trim($request->title));
        $allTheses = Thesis::all();

        $similarities = [];

        foreach ($allTheses as $thesis) {
            $existingTitle = strtolower(trim($thesis->title));
            $similarity = $this->calculateSimilarity($inputTitle, $existingTitle);

            if ($similarity > 0) {
                $similarities[] = [
                    'thesis' => $thesis,
                    'percentage' => $similarity
                ];
            }
        }

        // Sort by similarity percentage (descending)
        usort($similarities, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        $maxSimilarity = !empty($similarities) ? $similarities[0]['percentage'] : 0;

        return view('public.plagiarism', [
            'inputTitle' => $request->title,
            'similarities' => $similarities,
            'maxSimilarity' => $maxSimilarity
        ]);
    }

    private function calculateSimilarity($str1, $str2)
    {
        // Simple similarity calculation using similar_text function
        $similarity = 0;
        similar_text($str1, $str2, $similarity);
        return round($similarity, 2);
    }
}
