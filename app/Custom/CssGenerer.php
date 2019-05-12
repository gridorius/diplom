<?php

namespace App\Custom;

class CssGenerer{
    protected $fonts = [];
    protected $colors = [];
    protected $backgrounds = [];
    protected $linearGradients = [];
    protected $margins = [];
    protected $paddings = [];
    protected $gridCols = [];
    protected $widths =[];
    protected $heights = [];
    protected $gaps = [];

    protected $screenWidths = [];

    protected static function createPrefix($standart, $addition){
        return $addition ? $addition . '-' . $standart : $standart;
    }

    public function addFonts($arrayFonts){
        $this->fonts = array_merge($this->fonts, $arrayFonts);
    }

    public function addColorsAndBackgrounds($arrayColors){
        $this->addBackgrounds($arrayColors);
        $this->addColors($arrayColors);
    }

    public function addColors($arrayColors){
        $this->colors = array_merge($this->colors, $arrayColors);
    }

    public function addBackgrounds($arrayBackgrounds){
        $this->backgrounds = array_merge($this->backgrounds, $arrayBackgrounds);
    }

    public function addLinearGradients($arrayGradients){
        $this->linearGradients = array_merge($this->linearGradients, $arrayGradients);
    }

    public function addMargins($arrayMargins){
        $this->margins = array_merge($this->margins, $arrayMargins);
    }

    public function addPaddings($arrayPaddings){
        $this->paddings = array_merge($this->paddings, $arrayPaddings);
    }

    public function addGridCols($arrayColsCount){
        $this->gridCols = array_merge($this->gridCols, $arrayColsCount);
    }

    public function addWidths($arrayWidths){
        $this->widths = array_merge($this->widths, $arrayWidths);
    }

    public function addHeights($arrayHeights){
        $this->heights = array_merge($this->heights, $arrayHeights);
    }

    public function addGridGaps($arrayGaps){
        $this->gaps = array_merge($this->gaps, $arrayGaps);
    }

    public function addScreenWidths($arrayScreenWidths){
        $this->screenWidths = array_merge($this->screenWidths, $arrayScreenWidths);
    }

    public function build(){
        $css = "";

        $this->addFontsIn($css);
        $this->addColorsIn($css);
        $this->addBackgroundsIn($css);
        $this->addMarginsIn($css);
        $this->addPaddingsIn($css);
        $this->addWidthsIn($css);
        $this->addLinearGradientIn($css);
        $this->addHeightsIn($css);
        $this->addGridColsIn($css);
        $this->addGridGapsIn($css);
        $this->addGridColsSpanIn($css);

        $this->addMediaWidths($css);

        return $css;
    }

    public function addMediaWidths(&$css){
        foreach ($this->screenWidths as $prefix => $width)
            $this->adddMediaWidth($css, $prefix, $width);
    }

    public function adddMediaWidth(&$css, $prefix, $width){
        $header = "@media (max-width: {$width}px){\n";
        $footer = "}\n";

        $css.= $header;
        $this->addFontsIn($css, $prefix);
        $this->addMarginsIn($css, $prefix);
        $this->addPaddingsIn($css, $prefix);
        $this->addWidthsIn($css, $prefix);
        $this->addHeightsIn($css, $prefix);
        $css.= $footer;
    }

    protected function addFontsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('fs-', $prefix);
        foreach ($this->fonts as $font)
            $css .= (new CssClass("{$prefix}{$font}"))->setProp('font-size', $font . 'px')->build();
    }

    protected function addWidthsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('w-', $prefix);
        foreach ($this->widths as $width)
            $css .= (new CssClass("{$prefix}{$width}"))->setProp('width', $width . 'px')->build();
    }

    protected function addHeightsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('h-', $prefix);
        foreach ($this->heights as $height)
            $css .= (new CssClass("{$prefix}{$height}"))->setProp('height', $height . 'px')->build();
    }

    protected function addColorsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('c-', $prefix);
        foreach ($this->colors as $colorName => $colorGrad)
            foreach ($colorGrad as $key => $color){
                $css .= (new CssClass("{$prefix}{$colorName}-{$key}"))->setProp('color', $color)->build();
            }
    }

    protected function addBackgroundsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('b-', $prefix);
        foreach ($this->backgrounds as $colorName => $colorGrad)
            foreach ($colorGrad as $key => $color){
                $css .= (new CssClass("{$prefix}{$colorName}-{$key}"))->setProp('background-color', $color)->build();
            }
    }

    protected function addLinearGradientIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('lg-', $prefix);
        foreach ($this->linearGradients as $colorName => $gradOptions)
                $css .= (new CssClass("{$prefix}{$colorName}"))->setProp('background', "linear-gradient({$gradOptions[0]}, {$gradOptions[1]})")->build();
        }

    protected function addMarginsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('mg-', $prefix);
        foreach ($this->margins as $margin){
            $className = $prefix . implode('-', $margin);
            $value = implode('px ', $margin) . 'px';
            $css .= (new CssClass($className))->setProp('margin', $value)->build();
        }
    }

    protected function addPaddingsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('pd-', $prefix);
        foreach ($this->paddings as $padding){
            $className = $prefix . implode('-', $padding);
            $value = implode('px ', $padding) . 'px';
            $css .= (new CssClass($className))->setProp('padding', $value)->build();
        }
    }

    protected function addGridColsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('cols-', $prefix);
        foreach ($this->gridCols as $cols){
            $class = new CssClass($prefix . $cols);
            $class->setProp('display', 'grid');
            $class->setProp('grid-template-columns', "repeat({$cols}, 1fr)");
            $css .= $class->build();
        }
    }

    protected function addGridColsSpanIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('col-', $prefix);
        foreach ($this->gridCols as $cols){
            $class = new CssClass($prefix . $cols);
            $class->setProp('grid-column-end', "span {$cols}");
            $css .= $class->build();
        }
    }

    protected function addGridGapsIn(&$css, $prefix = ''){
        $prefix = static::createPrefix('gg-', $prefix);
        foreach ($this->gaps as $gap){
            $name = is_array($gap) ? implode('-', $gap) : $gap;

            $class = new CssClass($prefix . $name);

            if(is_array($gap)){
                $class->setProp('grid-row-gap', "{$gap[0]}px");
                $class->setProp('grid-column-gap', "{$gap[1]}px");
            }else{
                $class->setProp('grid-gap', "{$gap}px");
            }

            $css .= $class->build();
        }
    }
}