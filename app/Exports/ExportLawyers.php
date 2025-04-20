<?php

namespace App\Exports;

use App\Models\Lawyer\Lawyer;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportLawyers implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{

	public function headings(): array {
		return ['Name', 'Email', 'Phone Code', 'Mobile Number', 'Type', 'Status'];
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lawyer::all()->map(function($user) {
			switch ($user->accepted) {
				case 1 :
					$user->accepted = 'جديد';
					break;
				case 2 :
					$user->accepted = 'مقبول';
					break;
				case 3 :
					$user->accepted = 'انتظار';
					break;
				case 0 :
					$user->accepted = 'محظور';
					break;
			}
            switch ($user->type) {
				case 1 :
					$user->type = 'فرد';
					break;
				case 2 :
					$user->type = 'مؤسَّسة';
					break;
				case 3 :
					$user->type = 'شركة';
					break;
				case 4 :
					$user->type = 'جهة حكومية';
					break;
				case 5 :
					$user->type = 'اخرى';
					break;
				case null :
					$user->type = '--';
					break;
			}
			return collect($user)->only(['name', 'email', 'phone_code', 'phone', 'accepted', 'type']);
		});
    }

	public function map($serviceUser): array{
		return [
			$serviceUser['name'],
			$serviceUser['email'],
			$serviceUser['phone_code'],
			$serviceUser['phone'],
			$serviceUser['type'],
			$serviceUser['accepted']
		];
	}
}
