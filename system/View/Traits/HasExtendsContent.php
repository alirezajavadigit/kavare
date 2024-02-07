<?php

namespace System\View\Traits;


trait HasExtendsContent
{
    private $extendsContent;

    private function checkExtendsContent()
    {
        $layoutsFilePath = $this->findExtends();
        if ($layoutsFilePath) {
            $this->extendsContent = $this->viewLoader($layoutsFilePath);
            $yieldsNamesArray = $this->findYieldsNames();
            if ($yieldsNamesArray) {
                foreach ($yieldsNamesArray as $yieldName) {
                    $this->initialYields($yieldName);
                }
            }
            $this->content = $this->extendsContent;
        }
    }

    private function findExtends()
    {
        $filePathArray = [];
        preg_match("/s*@extends+\('([^)]+'\))/", $this->content, $filePathArray);
        return isset($filePathArray[1]) ? $filePathArray[1] : false;
    }

    private function findYieldsNames()
    {
        $yieldsNamesArray = [];
        preg_match_all("/@yield+\('([^)]+'\))/", $this->extendsContent, $yieldsNamesArray, PREG_UNMATCHED_AS_NULL);
        return isset($yieldsNamesArray[1]) ? $yieldsNamesArray[1] : false;
    }

    private function initialYields($yieldName)
    {
        $string = $this->content;
        $startWord = "@section('" . $yieldName . "')";
        $endWord = "@endsection";

        $startPos = strpos($string, $startWord);
        if ($startPos === false) {
            return $this->extendsContent = str_replace("@yield('$yieldName')", "", $this->extendsContent);
        }
        $startPos += strlen($startWord);
        $endPos = strpos($string, $endWord, $startPos);
        if ($endPos === false) {
            return $this->extendsContent = str_replace("@yield('$yieldName')", "", $this->extendsContent);
        }
        $length = $endPos - $startPos;
        $sectionContent = substr($string, $startPos, $length);
        return $this->extendsContent = str_replace("@yield('$yieldName')", $sectionContent, $this->extendsContent);
    }
}
