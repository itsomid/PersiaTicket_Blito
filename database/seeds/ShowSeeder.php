<?php

use App\Models\Show;
use App\Models\ShowSponsor;
use App\Models\Showtime;
use App\Models\Ticket;
use App\User;
use Illuminate\Database\Seeder;

class ShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!App::environment(['local', 'staging'])) {
            // The environment is either local OR staging...
            return;
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Show::truncate();
        Showtime::truncate();
        Ticket::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $show = new Show([
            'title' => 'جشنواره موسیقی ایران',
            'artist_name' => 'یک مجری تست',
            'subtitle' => 'بزرگترین جشنواره موسیقی خاورمیانه',
            'description' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.

لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.',
            'from_date' => \Carbon\Carbon::today()->addDays(15),
            'to_date' => \Carbon\Carbon::today()->addDays(17),
            'thumb_url' => "http://lorempixel.com/200/100/nightlife/?id=".time(),
            'main_image_url' => "http://lorempixel.com/800/400/nightlife/?id=".time(),
            'background_color' => '4facff',
            'terms_of_service' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.',
            'category_id' => 3,
            'sponsors' => [],
            'city_id' => 1
        ]);
        $show->admin_id = User::first()->id;
        $show->sponsors = [new ShowSponsor("Samsung","https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Samsung_Logo.svg/2000px-Samsung_Logo.svg.png","http://samsung.com")];
        $show->status = 'enabled';
        $show->save();
        $show->genres()->sync([1,2,3]);



        // sample theatre

        $theater = new Show([
            'title' => 'تئاتر تستی',
            'artist_name' => 'یک مجری تست',
            'subtitle' => 'تئاتر لورم ایپسام',
            'description' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.

لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.',
            'from_date' => \Carbon\Carbon::today()->addDays(25),
            'to_date' => \Carbon\Carbon::today()->addDays(27),
            'thumb_url' => "http://lorempixel.com/200/100/nightlife/?id=".time(),
            'main_image_url' => "http://lorempixel.com/800/400/nightlife/?id=".time(),
            'background_color' => '4facff',
            'terms_of_service' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.',
            'category_id' => 2,
            'sponsors' => [],
            'city_id' => 1
        ]);
        $theater->admin_id = User::first()->id;
        $theater->sponsors = [
            new ShowSponsor("Samsung","https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Samsung_Logo.svg/2000px-Samsung_Logo.svg.png","http://samsung.com"),
            new ShowSponsor("Apple","http://incitrio.com/wp-content/uploads/2015/01/Apple_gray_logo.png","http://apple.com")
        ];
        $theater->status = 'enabled';
        $theater->save();
        $theater->genres()->sync([4,5,6]);
        // sample concert

        $concert = new Show([
            'title' => 'کنسرت سهیل نفیسی',
            'artist_name' => 'سهیل نفیسی',
            'subtitle' => 'کنسرت لورم ایپسام',
            'description' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.

لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.',
            'from_date' => \Carbon\Carbon::today()->addDays(15),
            'to_date' => \Carbon\Carbon::today()->addDays(16),
            'thumb_url' => "http://lorempixel.com/200/100/nightlife/?id=".time(),
            'main_image_url' => "http://lorempixel.com/800/400/nightlife/?id=".time(),
            'background_color' => '4facff',
            'terms_of_service' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.',
            'category_id' => 1,
            'sponsors' => [],
            'city_id' => 1
        ]);
        $concert->admin_id = User::first()->id;
        $concert->status = 'enabled';
        $concert->is_cover = 1;
        $theater->genres()->sync([8,5,2]);
        $concert->save();

        $prices = [
            1 => [
                1 => -1,
                2 => -1,
            ],
            2 => [
                1 => 120000,
                2 => 120000,
                3 => 120000,
                4 => 120000,
                5 => 120000,
                6 => 100000,
                7 => 100000,
                8 => 100000,
                9 => 100000,
                10 => 100000,
                11 => 100000,
                12 => 100000,
            ],
            3 => [
                2 => 70000,
                3 => 70000,
                4 => 70000,
                5 => 70000,
                6 => 70000,
                7 => 70000,
                8 => 70000,
                9 => 70000,
                10 => 70000,
                11 => 70000,
                12 => 70000,
            ],
            4 => [
                2 => 70000,
                3 => 70000,
                4 => 70000,
                5 => 70000,
                6 => 70000,
                7 => 70000,
                8 => 70000,
                9 => 70000,
                10 => 70000,
                11 => 70000,
                12 => 70000,
            ],
            5 => [
                13 => -1,
                14 => -1,
                15 => -1,
                16 => 80000,
                17 => 80000,
                18 => 80000,
                19 => 80000,
                20 => 80000,
                21 => -1,
                22 => -1,
                23 => -1,
                24 => -1,
                25 => -1,
            ],
            6 => [
                13 => 60000,
                14 => 60000,
                15 => 60000,
                16 => 60000,
                17 => 60000,
                18 => 60000,
                19 => 60000,
                20 => 60000,
                21 => 60000,
                22 => 60000,
                23 => 60000,
                24 => 60000,
            ]
            ,
            7 => [
                13 => 60000,
                14 => 60000,
                15 => 60000,
                16 => 60000,
                17 => 60000,
                18 => 60000,
                19 => 60000,
                20 => 60000,
                21 => 60000,
                22 => 60000,
                23 => 60000,
                24 => 60000,
            ]
            ,
            8 => [
                1 => 50000,
                2 => 50000,
                3 => 50000,
                4 => 50000,
                5 => 50000,
                6 => 50000,
                7 => 50000,
            ],
            9 => [
                1 => 30000,
                2 => 30000,
                3 => 30000,
                4 => 30000,
                5 => 30000,
                6 => 30000,
                7 => 30000,
            ],
            10 => [
                1 => 30000,
                2 => 30000,
                3 => 30000,
                4 => 30000,
                5 => 30000,
                6 => 30000,
                7 => 30000,
            ],
            11 => [
                1 => -1,
                2 => -1,
                3 => -1,
                4 => -1,
                5 => -1,
                6 => -1,
                7 => -1,
            ],
            12 => [
                1 => -1,
                2 => -1,
                3 => -1,
                4 => -1,
                5 => -1,
                6 => -1,
                7 => -1,
            ]
        ];


        Showtime::createShowTimeForShow($show,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(15)->addHours(18), $prices);
        Showtime::createShowTimeForShow($show,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(15)->addHours(20), $prices);
        //Showtime::createShowTimeForShow($show,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(16)->addHours(19), $prices);
        //Showtime::createShowTimeForShow($show,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(16)->addHours(21), $prices);
        Showtime::createShowTimeForShow($show,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(17)->addHours(17), $prices);
        Showtime::createShowTimeForShow($show,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(17)->addHours(19), $prices);

        Showtime::createShowTimeForShow($theater,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(25)->addHours(19), $prices);
        Showtime::createShowTimeForShow($theater,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(25)->addHours(21), $prices);
        //Showtime::createShowTimeForShow($theater,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(27)->addHours(17), $prices);
        //Showtime::createShowTimeForShow($theater,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(27)->addHours(19), $prices);

        //Showtime::createShowTimeForShow($concert,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(15)->addHours(18.5), $prices);
        Showtime::createShowTimeForShow($concert,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(15)->addHours(21.5), $prices);
        //Showtime::createShowTimeForShow($concert,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(16)->addHours(18.5), $prices);
        //Showtime::createShowTimeForShow($concert,\App\Models\Scene::first(),\Carbon\Carbon::today()->addDays(16)->addHours(21.5), $prices);


        if (false)
        {
            // add some shows from Tiwall
            $sT = new \App\Classes\Seeb\Vendors\SeebTiwall();


            $categoryLists = $sT->retrieveCategoryList('drama');
            for ($i = 0; $i < min(count($categoryLists->data),10); $i++)
            {
                $twShow = $categoryLists->data[$i];
                try
                {
                    $sT->importShow($twShow->urn,2);
                }catch (\Exception $exception)
                {
                }

            }
            $categoryLists = $sT->retrieveCategoryList('concert');
            for ($i = 0; $i < min(count($categoryLists->data),10); $i++)
            {
                $twShow = $categoryLists->data[$i];
                try {
                    $sT->importShow($twShow->urn,1);
                }catch (\Exception $exception)
                {
                }

            }
            $categoryLists = $sT->retrieveCategoryList('conference');
            for ($i = 0; $i < min(count($categoryLists->data),10); $i++)
            {
                $twShow = $categoryLists->data[$i];
                try{
                    $sT->importShow($twShow->urn,3);
                }catch (\Exception $exception)
                {

                }
            }

            $sT->importShow('sampleEvent',1);

        }

        \Artisan::call('cache:clear');

    }
}
