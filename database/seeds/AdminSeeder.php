<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Geolocation;
use App\CitizenReports;
use App\TideUpdates;
use Carbon\Carbon;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          TideUpdates::create([
          'date_gathered' => 'Thu, 12 Apr 2018 00:00:03 GMT',
          'tideTime' => '2:49 AM',
          'tideHeight_mt' => 0.02,
          'tideDateTime' => '2018-04-12 02:49',
          'tideType' => 'LOW'
          ]);

        TideUpdates::create([
          'date_gathered' => 'Thu, 12 Apr 2018 00:00:03 GMT',
          'tideTime' => '10:00 AM',
          'tideHeight_mt' => 0.43,
          'tideDateTime' => '2018-04-12 10:00',
          'tideType' => 'HIGH'
          ]);
				$now = Carbon::now('Asia/Shanghai')->toDateTimeString();
				$admins = array(
					array('name' => 'Rannie Ollit', 'email' => 'einnar82@gmail.com', 'password' => bcrypt('sample123'), 'municipality' => 'Administrator',
					'is_verified' => '1', 'usercontact' => '09056499693', 'municipalAddress' => 'Calizon, Calumpit, Bulacan', 'userDate' => $now),
					array('name' => 'PDRRMO Bulacan', 'email' => 'pdrrmobulacan@gmail.com', 'password' => bcrypt('sample123'), 'municipality' => 'Bulacan',
					'is_verified' => '1', 'usercontact' => '098765432', 'municipalAddress' => 'Guinhawa, City of Malolos, Bulacan', 'userDate' => $now),
					array('name' => 'MDRRMO Malolos', 'email' => 'mdrrmomalolos@gmail.com', 'password' => bcrypt('sample123'), 'municipality' => 'Malolos',
					'is_verified' => '1', 'usercontact' => '098765432', 'municipalAddress' => 'San Vicente, Malolos, Bulacan', 'userDate' => $now),
				);
					$data = array(
                        array('rescuerName' => 'Jose Lapuz', 
                               'password' => 'rescue1', 
                                'lat' => 0, 
                                'lng' => 0, 
                                'assignRoute' => 'Calumpit',
                                 'municipality' => 'Bulacan'),
                         array('rescuerName' => 'Bryan Lopez', 
                               'password' => 'rescue2', 
                               'lat' => 0, 
                               'lng' => 0, 
                               'assignRoute' => 'Bulihan',
                               'municipality' => 'Malolos'),
                            );
 
		 
		   $reports = array(
         						array(
										'fullName' => 'Dessire Garan',
										'address' => 'Pungo, Calumpit, Bulacan',
										'contactNumber' => '09056499693',
										'landmark' => 'school',
										'type' => 'Fire',
										'reportedDate' => '2018-04-06 00:00:01',
										'municipality' => 'Calumpit',
										'lat' => 0,
										'lng' => 0,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
            			),
            array(
							'fullName' => 'Fatima Elaran',
							'address' => 'San Marcos, Calumpit, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Fire',
							'reportedDate' => '2018-04-05 00:00:01',
							'municipality' => 'Calumpit',
							'lat' => 0,
										'lng' => 0,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
            ),
                        array(
							'fullName' => 'Leni Elaran',
							'address' => 'San Marcos, Calumpit, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Fire',
							'reportedDate' => '2018-04-05 00:00:01',
							'municipality' => 'Calumpit',
							'lat' => 0,
										'lng' => 0,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
            ),
            array(
							'fullName' => 'Mayet Garan',
							'address' => 'Calizon, Calumpit, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Fire',
							'reportedDate' => '2018-04-04 00:00:01',
							'municipality' => 'Calumpit',
							'lat' => 0,
										'lng' => 0,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						array(
							'fullName' => 'Jon Roa',
							'address' => 'Pungo, Calumpit, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Fire',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Calumpit',
							'lat' => 0,
										'lng' => 0,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						array(
							'fullName' => 'cedrick abou',
							'address' => 'Pungo, Calumpit, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Weather',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Calumpit',
							'lat' => 14.916353,
										'lng' => 120.789585,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
							array(
							'fullName' => 'kyle De Guzman',
							'address' => 'Mojon, Malolos City, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Fire',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Malolos',
							'lat' => 14.868841,
										'lng' => 120.829795,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
						array(
							'fullName' => 'Devid Cutad',
							'address' => 'Lugam, Malolos City, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Rescue',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Malolos',
							'lat' => 14.882525,
										'lng' => 120.820550,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
												array(
							'fullName' => 'Pator Velayo',
							'address' => 'Gatbuca, Calumpit, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Accident',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Calumpit',
							'lat' => 14.923444,
										'lng' => 120.768039,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
																		array(
							'fullName' => 'Jose Lean Sanjuan',
							'address' => 'Tabang, Guiguinto, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Accident',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Calumpit',
							'lat' => 14.833680,
										'lng' => 120.865685,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
									array(
							'fullName' => 'raymond Bonifacio',
							'address' => 'Calumpang, Calumpit, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Accident',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Calumpit',
							'lat' => 14.885792,
										'lng' => 120.776658,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
											array(
							'fullName' => 'Rica Blasabas',
							'address' => 'Lugam, Malolos City, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Landslide',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Malolos',
							'lat' => 14.882525,
										'lng' => 120.820550,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
																		array(
							'fullName' => 'Adrian Reyes',
							'address' => 'Bintog, Plaridel, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Emergency',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Plaridel',
							'lat' => 14.900777,
										'lng' => 120.885779,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
															array(
							'fullName' => 'Redel Santiago',
							'address' => 'Pinagbakahan, Malolos City, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Fire',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Malolos',
							'lat' => 14.872170,
										'lng' => 120.820462,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						
																			array(
							'fullName' => 'Kimmy James Sanchez',
							'address' => 'Barihan, Malolos City, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Weather',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Malolos',
							'lat' => 14.876865,
										'lng' => 120.836974,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),

																						array(
							'fullName' => 'Gav Santos',
							'address' => 'Mojon, Malolos City, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Accident',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Malolos',
							'lat' => 14.868841,
										'lng' => 120.829795,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
                        array(
							'fullName' => 'Jhon Jhon Deguzman',
							'address' => 'Mojon, Malolos City, Bulacan',
							'contactNumber' => '09056499693',
							'landmark' => 'school',
							'type' => 'Rescue',
							'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
							'municipality' => 'Malolos',
							'lat' => 14.868841,
										'lng' => 120.829795,
										'ip' => request()->ip(),
										'status' => 'Undone',
										'rescuedTime' => '',
										'respondTime' => '',
						),
						

            
			);
						
            CitizenReports::insert($reports);
						Geolocation::insert($data);
						Admin::insert($admins);
    }
}
