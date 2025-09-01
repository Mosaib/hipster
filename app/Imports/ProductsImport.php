<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, SkipsOnFailure, WithEvents, ShouldQueue
{
    use SkipsFailures, Importable;

    /**
     * Public properties
     */
    public $failuresMessages = [];

    /**
     * Protected properties
     */
    protected $requiredHeaders = [
        'name',
        'description',
        'price',
        'category',
        'stock',
        'image'
    ];

    /**
     * Register events for the import
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function () {
                $file = request()->file('file'); // directly from request

                if (!$file) {
                    throw new \Exception("No file uploaded.");
                }

                // Read heading row
                $headingRow = (new HeadingRowImport)->toArray($file)[0][0] ?? [];
                $headingRow = array_map(fn($h) => strtolower(trim($h)), $headingRow);

                // Check for missing headers
                $missing = array_diff($this->requiredHeaders, $headingRow);

                if (!empty($missing)) {
                    // Throw a normal exception instead
                    throw new \Exception('Missing required headers: ' . implode(', ', $missing));
                }
            },
        ];
    }

    /**
     * Create model from row data
     *
     * @param array $row
     * @return Product
     */
    public function model(array $row)
    {
        $row = array_change_key_case($row, CASE_LOWER);

        return new Product([
            'name'        => $row['name'] ?? null,
            'description' => $row['description'] ?? null,
            'price'       => $row['price'] ?? 0,
            'category'    => $row['category'] ?? null,
            'stock'       => $row['stock'] ?? 0,
            'image'       => $row['image'] ?? null,
        ]);
    }

    /**
     * Validation rules for import
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|url',
        ];
    }

    /**
     * Handle validation failures
     *
     * @param mixed ...$failures
     * @return void
     */
    public function onFailure(...$failures)
    {
        foreach ($failures as $failure) {
            $this->failuresMessages[] = 'Row ' . $failure->row() . ' : ' . implode(', ', $failure->errors());
        }
    }

    /**
     * Set chunk size for processing
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 5000;
    }
}