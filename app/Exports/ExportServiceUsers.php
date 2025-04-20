<?php

namespace App\Exports;

use App\Models\Service\ServiceUser;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportServiceUsers implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{

	public function headings(): array {
		return ["Name", 'Email', 'Phone Code', 'Mobile Number', 'Type', 'Status'];
	}
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServiceUser::all()->map(function($user) {
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
			return collect($user)->only(['email', 'phone_code', 'mobil', 'type', 'accepted', 'myname']);
		});
    }

	public function map($serviceUser): array{
		return [
			$serviceUser['myname'],
			$serviceUser['email'],
			$serviceUser['phone_code'],
			$serviceUser['mobil'],
			$serviceUser['type'],
			$serviceUser['accepted']
		];
	}
}
