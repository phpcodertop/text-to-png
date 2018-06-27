<?php 
class Create_Img_Png{

	private $backgroundImage = 'background.png';

	public function create($text='',$signature='')
	{
        header('Content-type: image/png');
        $text = wordwrap($text,28);
		$img = @imagecreatefrompng($this->backgroundImage);
		if($img){

	        $black = imagecolorallocate($img, 0, 0, 0);
	        // Replace path by your own font path
	        $font = 'verdana.ttf';
	        //
            $txt_space = imagettfbbox(15, 0, $font, $text);

            // Determine text width and height
            $txt_width = abs($txt_space[4] - $txt_space[0]);
            $txt_height = abs($txt_space[3] - $txt_space[1]);
            // Get image Width and Height
            $image_width_old = imagesx($img);
            $image_height_old = imagesy($img);

            $text = wordwrap($text, (imagesx($img)/10));
            $lines = explode("\n", $text);

            $newHeight = count($lines) * 15 * 3;
            $tmp = imagecreatetruecolor($image_width_old, $newHeight);
            imagecopyresampled($tmp, $img, 0, 0, 0, 0, $image_width_old, $newHeight, $image_width_old, $image_height_old);

            $img = $tmp;
            $image_width = imagesx($img);
            $image_height = imagesy($img);

            $line_height = 15;
            $c = 0;

            $y = (abs($image_height - $txt_height) /2)- (count($lines) * 5);
            foreach($lines as $line){
                $txt_space_line = imagettfbbox(17, 0, $font, $line);
                $txt_width_line = abs($txt_space_line[4] - $txt_space_line[0]);
                $x_line = abs($image_width - $txt_width_line) / 2;
                imagettftext($img, 18, 0, $x_line, $y+$c - ((count($lines) * $line_height) / 2), $black, $font, trim($line));
                $c += 30;
            }

            imagettftext($img, 20, 0, $image_width - 200, $image_height - 30, $black, $font, $signature);
	        imagepng($img);
	        imagedestroy($img);
		}else{
			die("can't open image");
		}
	}



}

?>