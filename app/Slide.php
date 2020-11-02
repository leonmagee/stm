<?php

namespace App;

class Slide extends Model
{
    public function update_order($order, $duplicate = false)
    {
        if (!$this->order || $duplicate) {
            $this->order = $order;
            $this->save();
            $slides = Slide::where('id', '!=', $this->id)
                ->where('order', '>=', $order)
                ->get();
            foreach ($slides as $slide) {
                $slide->order++;
                $slide->save();
            }
        } else {
            $existing_order = $this->order;
            $this->order = $order;
            $this->save();
            if ($order < $existing_order) {
                $slides = Slide::where('id', '!=', $this->id)
                    ->where('order', '>=', $order)
                    ->where('order', '<', $existing_order)
                    ->get();
                foreach ($slides as $slide) {
                    $slide->order++;
                    $slide->save();
                }
            } elseif ($order > $existing_order) {
                $slides = Slide::where('id', '!=', $this->id)
                    ->where('order', '>', $existing_order)
                    ->where('order', '<=', $order)
                    ->get();
                foreach ($slides as $slide) {
                    $slide->order--;
                    $slide->save();
                }

            }
        }

    }
}
