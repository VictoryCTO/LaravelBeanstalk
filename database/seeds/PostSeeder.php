<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        # This creates the articles
        # Bacon Ipsum is utilized to keep things interesting

        $users = \App\User::get();
        $client = new \GuzzleHttp\Client();
        foreach ($users as $user) {
            for ($i = 0; $i < Config::get('dev.seed.posts_per_user'); $i++) {
                $article = $client->get('https://baconipsum.com/api/?type=all-meat&paras=9');
                $article_body = json_decode((string)$article->getBody());

                $title = implode(' ', array_slice(explode(' ', $article_body[0]), 0, 8));
                $image = 'https://baconmockup.com/600/300/';
                $article_body[0] = '<img src="'.$image.'">';
                $article_body[3] = '<img src="'.$image.'">';
                $article_insert = [
                    'author_id' => $user->id,
                    'title' => $title,
                    'header_image' => $image,
                    'body' => "<p>".implode("</p><p>", $article_body)."</p>",

                ];
                \App\Posts::create($article_insert);
            }
        }

        # This will relate the articles

        $posts = \App\Posts::get();
        foreach($posts as $post) {
            $related = \App\Posts::orderBy(\Illuminate\Support\Facades\DB::raw('RAND()'))->take(10)->get();
            foreach($related as $rpost) {
                $ins = [
                    'post_id' => $post->post_id,
                    'related_id' => $rpost->post_id
                ];
                \App\RelatedPosts::create($ins);
            }
        }


    }
}
