<?php
/*
 * File: socials.php
 *
 * Description: This file includes functions for:
 *              - Feedburner reader count
 *              - Twitter followers count
 *              - Getting Flickr stream
 *              - Getting Twitter timeline
 *
 */



/*******************************************************************************
 * Function:  grey_feeds_count()
 * Description: return the number of Feedburner readers
 *
 * @param string $id : feedburner id
 *
 * @return int
 *******************************************************************************
*/
function grey_feeds_count( $id ) {
    $fb_readers = get_option('grey_feedburner_count');

    if ( get_option('grey_feedburner_timer') < (mktime() - 3600) || $fb_readers==0 ) {
        $xml = simplexml_load_file("https://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=" . $id)
                    or die ("Unable to load XML file");

        $circulation = (string) $xml->feed->entry['circulation'];
        if( $circulation != 0 ) {
            $fb_readers = $circulation;
            update_option('grey_feedburner_count',$circulation);
        }

        update_option('grey_feedburner_timer', mktime());
    }
    
    return $fb_readers;
}


/*******************************************************************************
 * Function:  grey_twitter_count()
 * Description: return the number of Twitter followers
 *
 * @param string $id : twitter id
 *
 * @return int
 *******************************************************************************
*/
function grey_twitter_count( $id ) {
    $tw_followers = get_option('grey_twitter_count');

    if ( get_option('grey_twitter_timer') < (mktime() - 3600) || $tw_followers == 0 ) {
    
        $ch = curl_init("http://twitter.com/users/show.xml?screen_name=" . $id);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_USERAGENT,"GREY");
        curl_setopt($ch,CURLOPT_TIMEOUT,10);
        $data = curl_exec($ch);
        if (curl_errno($ch) !== 0 || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            $data === false;
        }
        curl_close($ch);

        $xml = new SimpleXmlElement($data, LIBXML_NOCDATA);
    
        $followers = (string) $xml->followers_count;
        if( $followers != 0 ) {
            $tw_followers = $followers;
            update_option('grey_twitter_count',$followers);
        }

        update_option('grey_twitter_timer', mktime());
    }
    
    return $tw_followers;
}


/*******************************************************************************
 * Function:  grey_flickr_stream()
 * Description: return images from flickr
 *
 * @param string $id : Optional, flickr id
 * @param int    $nr : Optional, Default = 9, number of images to show
 *
 * @return string
 *******************************************************************************
*/
function grey_flickr_stream( $id=NULL, $nr=9 ) {
    $feed = "http://api.flickr.com/services/feeds/photos_public.gne?format=rss_200";
    if(isset($id)) $feed .= "&id=$id";
    $return = "";

    $xml = simplexml_load_file($feed)
                or die ("Unable to load XML file");
                
    $i = 0;
    foreach( $xml->channel->item as $row ) {
        if( $i<$nr ) {
            $pattern = '~<img [^>]* />~';
            $images = '';
            $link = $row->link;

            preg_match_all( $pattern, $row->description, $imgs );

            foreach($imgs as $img) {
                preg_match_all( '/src=("[^"]*")/i', $img[0], $images_temp[$img[0]] );
                $images_temp = preg_replace( '/_m.(png|jpg|jpeg|bmp|gif)/i', '_s.$1' , $images_temp[$img[0]][1] );
            }
            
            $return .= "<a href='{$row->link}' title='{$row->title}'><img src={$images_temp[0]} alt='{$row->title}' /></a>\n";
        } else break;

        $i++;
    }
    return $return;
}


/*******************************************************************************
 * Function:  grey_twitter_timeline()
 * Description: return the twitter timeline
 *
 * @param string $id : Optional, twitter id
 * @param int    $nr : Optional, Default = 5, number of tweets to show
 *
 * @return string
 *******************************************************************************
*/
function grey_twitter_timeline( $id=NULL, $nr=5 ) {
    $feed = "http://twitter.com/statuses/public_timeline.rss";
    if($id) $feed = str_replace( "public_timeline", "user_timeline/".$id, $feed );


    $ch = curl_init($feed);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_USERAGENT,"GREY");
    curl_setopt($ch,CURLOPT_TIMEOUT,10);
    $data = curl_exec($ch);
    if (curl_errno($ch) !== 0 || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
        $data === false;
    }
    curl_close($ch);

    $xml = new SimpleXmlElement($data, LIBXML_NOCDATA);
    if(!$xml->error) {
        $i = 0;
        $return = "<ul class='twitter_list'>";
        foreach( $xml->channel->item as $row ) {
            if( $i<$nr ) {
                (isset($id)) ? $title = preg_replace( "/^$id: /",'', $row->title) : $title = $row->title;
    
                $title = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $title);
                $title = preg_replace("/@(\w+)/", '<a href="http://twitter.com/$1">@$1</a>', $title);
                $title = preg_replace("/#(\w+)/", '<a href="http://twitter.com/#search?q=$1">#$1</a>', $title);
    
                $return .= "<li>". $title ."</li>";
            }
    
            $i++;
        }
    
        update_option('grey_twitter_timeline', $return);
        return $return . "</ul>";
    } else {
        return get_option('grey_twitter_timeline');
    }
}

?>