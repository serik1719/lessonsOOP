<?php

/**
 * Класс для генерации постаничной навигации
 */
class Pagination{
    private $path;
    private $nPage;
    private $allRecord;
    private $allPage;
    private $pagePlusMinus;
    
    /**
    * Конструктор
    * 
    * Параметры:
    * 
    * 1) URL кнопок, например: /category/2/page-
    * 
    * 2) Номер текущей страницы
    * 
    * 3) Всего записей
    * 
    * 4) Количество записей на одной странице
    * 
    * 5) Количество отображаемых кнопок назад и вперёд (не меньше 1) <b>по умолчанию = 2</b>
    */
    public function __construct($path, $nPage, $allRecord, $ReccordOnePage, $pagePlusMinus = 2) {
        $this->path = $path;
        $this->nPage = self::validationPage($nPage);
        $this->allRecord = $allRecord;
        $this->allPage = ceil($allRecord / $ReccordOnePage);
        $this->pagePlusMinus = $pagePlusMinus;
        
        if($this->nPage > $this->allPage){
            if($this->allPage != 0 || $this->nPage != 1){
                Router::ErrorPage404();
            }
        }
    }
    
    /**
    * Метод формирующий html - код кнопок страниц
    * 
    * Возвращает <b>HTML</b> код пагинатора
    */
    public function get(){
        if($this->allRecord > 0){
            if($this->nPage < 1){
                $this->nPage = 1;
            }
            
            if($this->pagePlusMinus < 1){
                $this->pagePlusMinus = 1;
            }
            
            $html = '<div class="PageSelector">';

            if($this->nPage != 1){
                $html .= '<a class="SwitchPage" href="'.$this->path.($this->nPage-1).'">&#9668</a>';
            }else{
                $html .= '<span class="SwitchPageCurrent">&#9668</span>';
            }
            if($this->nPage > $this->pagePlusMinus+1){
                $html .= '<a class="SwitchPage" href="'.$this->path.'1">1</a>';
            }
            if($this->nPage > $this->pagePlusMinus+2){
                $html .= '<span class="Point">. . .</span>';
            }

            for($i = ($this->nPage - $this->pagePlusMinus); $i < ($this->allPage + 1); $i++){
                if($i > 0 and $i <= ($this->nPage + $this->pagePlusMinus)){
                    if($this->nPage == $i){
                        $html .= '<span class="SwitchPageCurrent">'.$i.'</span>';
                    }else{
                        $html .= '<a class="SwitchPage" href="'.$this->path.$i.'">'.$i.'</a>';
                    }
                }
            }

            if($this->allPage-3 > $this->nPage){
                $html .= '<span class="Point">. . .</span>';
            }
            if($this->allPage-2 > $this->nPage){
                $html .= '<a class="SwitchPage" href="'.$this->path.$this->allPage.'">'.$this->allPage.'</a>';
            }
            if($this->nPage != $this->allPage){
                $html .= '<a class="SwitchPage" href="'.$this->path.($this->nPage+1).'">&#9658</a>';
            }else{
                $html .= '<span class="SwitchPageCurrent">&#9658</span>';
            }

            $html .= '</div>';
            
            return $html;
        }else{
            return false;
        }
    }
    
    /**
     * Проверка правильности номера страницы<br>
     * Возвращает номер страницы если страница >= 1 или "1" если страница < 1
     * @return int
     */
    private static function validationPage($page){
        $page = intval($page);
        if($page <= 0){
            Router::ErrorPage404();
        }
        return $page;
    }
}
