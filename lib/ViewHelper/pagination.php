<?php

  /**
   * Classe Paginator
   * permet de paginer
   *
   *
   * @todo : Commenter plus le code
  */

  namespace Helper;

  class Paginator
  {



    //public $nbPage;

    protected $_variables = array(
            'classes' => array(
                              'nav'=>array('text-center'),
                              'ul' =>array('pagination'),
                              'li' =>array(),
                              'liactive' =>array('active'),
                              'nextdisabled'=>array('disabled'),
                              'prevdisabled'=>array('disabled'),
                              'troncature'=>array('disabled'),
                              ),
            'rpp' => 5,
            'key' => 'page',
            'target' => '',
            'next' => 'Next &raquo;',
            'previous' => '&laquo; Previous',
            'troncature'   => '&hellip;'
        );



    public $pagination = array(); // variable retour de la fonction : vide tant qu'il n'y a pas au moins 2 pages

    function __construct($current = null, $total = null)
    {
      // current instantiation setting
      if (!is_null($current)) {
          $this->setCurrent($current);
      }
      // total instantiation setting
      if (!is_null($total)) {
          $this->setTotal($total);
      }

      $this->_variables['get'] = $_GET;
      $this->_variables['target']=$_SERVER['PHP_SELF'];
    }

    protected function _check()
    {

        if(!isset($this->_variables['nbPage'])){
          $this->_variables['nbPage']=ceil($this->_variables['total']/$this->_variables['rpp']);
        }
        if (!isset($this->_variables['current'])) {
            throw new Exception('Pagination::current must be set.');
        } elseif (!isset($this->_variables['total'])) {
            throw new Exception('Pagination::total must be set.');
        }
    }


    public function parse()
    {

      $this->_check();

      $out="";
      $out.='<nav class="'.implode(" ", $this->_variables['classes']['nav']).'">';
      $out.='<ul class="'.implode(" ", $this->_variables['classes']['ul']).'">';
      $out.=$this->prev();
      $out.=$this->number();
      $out.=$this->next();
      $out.='</ul>';
      $out.='</nav>';
      return $out;

    }


    function prev()
    {

      $this->_check();

      $cPage= $this->_variables['current'];
      $prev = $cPage - 1; // numéro de la page précédente

      //$pagination=array();
      $li='<li class="%s"><a href="%s">%s</a></li>';


      if ($cPage == 2) {
        // la page courante est la 2, le bouton renvoie donc sur la page 1
        $class=$this->_variables['classes']['li'];
        $out=sprintf($li,implode(' ', $class),$this->formatHref("1"),$this->_variables['previous']);


      } elseif ($cPage > 2) {
        // la page courante est supérieure à 2, le bouton renvoie sur la page dont le numéro est immédiatement inférieur
        $class=$this->_variables['classes']['li'];
        $out=sprintf($li,implode(' ', $class),$this->formatHref($prev),$this->_variables['previous']);

      } else {

        // dans tous les autres, cas la page est 1 : désactivation du bouton [précédent]

        $class=array_merge($this->_variables['classes']['prevdisabled'],$this->_variables['classes']['li']);
        $out=sprintf($li, implode(' ', $class),'#',$this->_variables['previous']);

      }

      return $out;

    }


    function next()
    {

      $this->_check();
      $cPage= $this->_variables['current'];
      $nbPage = $this->_variables['nbPage'];
      $next = $cPage + 1; // numéro de la page suivante

      $li='<li class="%s"><a href="%s">%s</a></li>';

      if ($cPage == $nbPage){
        $class=array_merge($this->_variables['classes']['nextdisabled'],$this->_variables['classes']['li']);
        $out=sprintf($li, implode(' ', $class),'#',$this->_variables['next']);
      }

      else
      {
        $class=$this->_variables['classes']['li'];
        $out=sprintf($li,implode(' ', $class),$this->formatHref($next),$this->_variables['next']);

      }

      return $out;

    }


     function number($adj=1)
    {

      $this->_check();


      $li='<li class="%s"><a href="%s">%s</a></li>';

      $cPage=$this->_variables['current'];
      $nbPage=$this->_variables['nbPage'];


      $prev = $cPage - 1; // numéro de la page précédente
      $next = $cPage + 1; // numéro de la page suivante
      $penultimate = $nbPage - 1; // numéro de l'avant-dernière page

      $pagination=array();

      if($nbPage<=1)
      {
        return false;
      }


      /**
       * Début affichage des pages, l'exemple reprend le cas de 3 numéros de pages adjacents (par défaut) de chaque côté du numéro courant
       * - CAS 1 : il y a au plus 12 pages, insuffisant pour faire une troncature
       * - CAS 2 : il y a au moins 13 pages, on effectue la troncature pour afficher 11 numéros de pages au total
       */

      /* ===============================================
       *  CAS 1 : au plus 12 pages -> pas de troncature
       * =============================================== */
      if ($nbPage < 7 + ($adj * 2)) {

        for ($i=1; $i<=$nbPage; $i++) {
          if ($i == $cPage)
          {

            $class=array_merge($this->_variables['classes']['liactive'],$this->_variables['classes']['li']);
            $out=sprintf($li,implode(' ', $class),"#",$i);
            array_push($pagination, $out);

          } else
          {

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref($i),$i);
            array_push($pagination, $out);

          }
        }
      }


      /* =========================================
       *  CAS 2 : au moins 13 pages -> troncature
       * ========================================= */
      else {
          /**
           * Troncature 1 : on se situe dans la partie proche des premières pages, on tronque donc la fin de la pagination.
           * l'affichage sera de neuf numéros de pages à gauche ... deux à droite
           * 1 2 3 4 5 6 7 8 9 … 16 17
           */
          if ($cPage < 2 + ($adj * 2)) {

            // puis des huit autres suivants
            for ($i=1; $i< 4 + ($adj * 2); $i++) {
              if ($i == $cPage)
              {

                $class=array_merge($this->_variables['classes']['liactive'],$this->_variables['classes']['li']);
                $out=sprintf($li,implode(' ', $class),"#",$i);
                array_push($pagination, $out);

              } else
              {

                $class=$this->_variables['classes']['li'];
                $out=sprintf($li,implode(' ', $class),$this->formatHref($i),$i);
                array_push($pagination, $out);

              }
            }

            // ... pour marquer la troncature

            $class=array_merge($this->_variables['classes']['troncature'],$this->_variables['classes']['li']);
            $out=sprintf($li,implode(' ', $class),"#",$this->_variables['troncature']);
            array_push($pagination, $out);


            // et enfin les deux derniers numéros

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref($penultimate),$penultimate);
            array_push($pagination, $out);

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref($nbPage),$nbPage);
            array_push($pagination, $out);


          }


          /**
           * Troncature 2 : on se situe dans la partie centrale de notre pagination, on tronque donc le début et la fin de la pagination.
           * l'affichage sera deux numéros de pages à gauche ... sept au centre ... deux à droite
           * 1 2 … 5 6 7 8 9 10 11 … 16 17
           */
          elseif ( (($adj * 2) + 1 < $cPage) && ($cPage < $nbPage - ($adj * 2)) )
          {
            // Affichage des numéros 1 et 2

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref("1"),"1");
            array_push($pagination, $out);

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref("2"),"2");
            array_push($pagination, $out);

            // ... pour marquer la troncature

            $class=array_merge($this->_variables['classes']['troncature'],$this->_variables['classes']['li']);
            $out=sprintf($li,implode(' ', $class),"#",$this->_variables['troncature']);
            array_push($pagination, $out);



            // les pages du milieu : les trois précédant la page courante, la page courante, puis les trois lui succédant
            for ($i = $cPage - $adj; $i <= $cPage + $adj; $i++)
            {
              if ($i == $cPage)
              {

                $class=array_merge($this->_variables['classes']['liactive'],$this->_variables['classes']['li']);
                $out=sprintf($li,implode(' ', $class),"#",$i);
                array_push($pagination, $out);

              } else
              {

                $class=$this->_variables['classes']['li'];
                $out=sprintf($li,implode(' ', $class),$this->formatHref($i),$i);
                array_push($pagination, $out);

              }
            }

            // ... pour marquer la troncature

            $class=array_merge($this->_variables['classes']['troncature'],$this->_variables['classes']['li']);
            $out=sprintf($li,implode(' ', $class),"#",$this->_variables['troncature']);
            array_push($pagination, $out);

            // et enfin les deux derniers numéros

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref($penultimate),$penultimate);
            array_push($pagination, $out);

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref($nbPage),$nbPage);
            array_push($pagination, $out);

          }
          /**
           * Troncature 3 : on se situe dans la partie de droite, on tronque donc le début de la pagination.
           * l'affichage sera deux numéros de pages à gauche ... neuf à droite
           * 1 2 … 9 10 11 12 13 14 15 16 17
           */
          else
          {
            // Affichage des numéros 1 et 2

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref("1"),"1");
            array_push($pagination, $out);

            $class=$this->_variables['classes']['li'];
            $out=sprintf($li,implode(' ', $class),$this->formatHref("2"),"2");
            array_push($pagination, $out);

            // ... pour marquer la troncature

            $class=array_merge($this->_variables['classes']['troncature'],$this->_variables['classes']['li']);
            $out=sprintf($li,implode(' ', $class),"#",$this->_variables['troncature']);
            array_push($pagination, $out);

            // puis des neuf derniers numéros
            for ($i = $nbPage - (2 + ($adj * 2)); $i <= $nbPage; $i++) {
              if ($i == $cPage)
              {

                $class=array_merge($this->_variables['classes']['liactive'],$this->_variables['classes']['li']);
                $out=sprintf($li,implode(' ', $class),"#",$i);
                array_push($pagination, $out);

              } else
              {
                $class=$this->_variables['classes']['li'];
                $out=sprintf($li,implode(' ', $class),$this->formatHref($i),$i);
                array_push($pagination, $out);

              }
            }
          }
      }
      return implode(" ", $pagination);


    }


    private function formatHref($page){
      $params = $this->_variables['get'];
      $params[$this->_variables['key']] = ($page);
      $href = ($this->_variables['target']) . '?' . http_build_query($params);
      $href = preg_replace(
            array('/=$/', '/=&/'),
            array('', '&'),
            $href
      );

      return $href;
    }


    public function getLimit()
    {
        $a = (($this->_variables['current']-1)*$this->_variables['rpp']);
        $b = $this->_variables['rpp'];

        $out = $a .", " . $b;
        return $out;
    }

     /**
     * setCurrent
     *
     * Sets the current page being viewed.
     *
     * @access public
     * @param  integer $current
     * @return void
     */

    public function setCurrent($current)
    {
        $this->_variables['current'] = $current;
    }

    /**
     * setKey
     *
     * Sets the key of the <_GET> array that contains, and ought to contain,
     * paging information (eg. which page is being viewed).
     *
     * @access public
     * @param  string $key
     * @return void
     */

    public function setKey($key)
    {
        $this->_variables['key'] = $key;
    }
    /**
     * setNext
     *
     * Sets the copy of the next anchor.
     *
     * @access public
     * @param  string $str
     * @return void
     */

    public function setNext($str)
    {
        $this->_variables['next'] = $str;
    }
    /**
     * setPrevious
     *
     * Sets the copy of the previous anchor.
     *
     * @access public
     * @param  string $str
     * @return void
     */

    public function setPrevious($str)
    {
        $this->_variables['previous'] = $str;
    }
    /**
     * setRPP
     *
     * Sets the number of records per page (used for determining total
     * number of pages).
     *
     * @access public
     * @param  integer $rpp
     * @return void
     */
    public function setRPP($rpp)
    {
        $this->_variables['rpp'] = $rpp;
    }
    /**
     * setTarget
     *
     * Sets the leading path for anchors.
     *
     * @access public
     * @param  string $target
     * @return void
     */

    public function setTarget($target)
    {
        $this->_variables['target'] = $target;
    }
    /**
     * setTotal
     *
     * Sets the total number of records available for pagination.
     *
     * @access public
     * @param  integer $total
     * @return void
     */

    public function setTotal($total)
    {
        $this->_variables['total'] = $total;
    }


    public function setClasses($classes=array(),$to)
    {
      if ($to=="prev") {
        $this->_variables['classes']['prevdisabled'] = $classes;

      }
      elseif ($to=="next")
      {
        $this->_variables['classes']['nextdisabled'] = $classes;

      }
      elseif ($to=="nav")
      {
        $this->_variables['classes']['nav'] = $classes;
      }
      elseif ($to=="ul")
      {
        $this->_variables['classes']['ul'] = $classes;
      }
      elseif ($to=="li")
      {
        $this->_variables['classes']['li'] = $classes;
      }
      elseif ($to=="truncation")
      {
        $this->_variables['classes']['troncature'] = $classes;
      }

    }



    /**
         * getRelPrevNextLinkTags
         *
         * @see    http://support.google.com/webmasters/bin/answer.py?hl=en&answer=1663744
         * @see    http://googlewebmastercentral.blogspot.ca/2011/09/pagination-with-relnext-and-relprev.html
         * @see    http://support.google.com/webmasters/bin/answer.py?hl=en&answer=139394
         * @access public
         * @return array
         */
        public function getRelPrevNextLinkTags()
        {

            $this->_check();
            // generate path
            $target = $this->_variables['target'];
            if (empty($target)) {
                $target = $_SERVER['PHP_SELF'];
            }
            $key = $this->_variables['key'];
            $params = $this->_variables['get'];
            $params[$key] = 'pgnmbr';
            $href = ($target) . '?' . http_build_query($params);
            $href = preg_replace(
                array('/=$/', '/=&/'),
                array('', '&'),
                $href
            );
            $href = 'http://' . ($_SERVER['HTTP_HOST']) . $href;
            // Pages
            $currentPage = (int) $this->_variables['current'];
            $numberOfPages = (
                (int) ceil(
                    $this->_variables['total'] /
                    $this->_variables['rpp']
                )
            );
            // On first page
            if ($currentPage === 1) {
                // There is a page after this one
                if ($numberOfPages > 1) {
                    $href = str_replace('pgnmbr', 2, $href);
                    return '<link rel="next" href="' . ($href) . '" />';

                }
                return;
            }
            // Store em
            $prevNextTags = array(
                '<link rel="prev" href="' . (str_replace('pgnmbr', $currentPage - 1, $href)) . '" />'
            );
            // There is a page after this one
            if ($numberOfPages > $currentPage) {
                array_push(
                    $prevNextTags,
                    '<link rel="next" href="' . (str_replace('pgnmbr', $currentPage + 1, $href)) . '" />'
                );
            }
            return implode(" ", $prevNextTags);
        }


  }
 ?>
