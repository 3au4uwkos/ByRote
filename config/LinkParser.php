<?php
    declare(strict_types=1);

    class LinkParser
    {
        private static string $links = __DIR__ . DIRECTORY_SEPARATOR . "Links.json";

        private static string $errorLogger = ".." . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . "ErrorLogger.log";
       
        private static function getData() 
        {
            
            try
            {
                $data = json_decode(file_get_contents(LinkParser::$links),TRUE);
                return $data;

            } catch (Throwable $th)
            {
                $message = "Something went wrong with JSON-file";
                error_log(date('d.m.Y h:i:s') . " " . $message .PHP_EOL, 3, LinkParser::$errorLogger);
            }
        }
        public static function getLink(string $component)
        {
            $data = LinkParser::getData();
            try
            {
                if(!(array_key_exists($component,$data)))
                {
                    throw new Exception("KEK");
                }
                return $data["domen"] . $data[$component];

            } catch (Throwable $t)
            {
                $message = "Couldn't read the value from JSON file";
                error_log(date('d.m.Y h:i:s') . " " . $message .PHP_EOL, 3, LinkParser::$errorLogger);
            } catch (Exception $e)
            {
                $message = "There's not " . $component . " in the JSON";
                error_log(date('d.m.Y h:i:s') . " " . $message .PHP_EOL, 3, LinkParser::$errorLogger);
            }
        }
    }
?>