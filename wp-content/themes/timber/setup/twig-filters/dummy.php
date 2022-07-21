<?php

function simple_truncate($phrase, $max_words) {
    $phrase_array = explode(' ', $phrase);
    if (count($phrase_array) > $max_words && $max_words > 0) {
        $phrase = implode(' ', array_slice($phrase_array, 0, $max_words));
    }
    return $phrase;
}

function apply_dummy($words) {
    $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non nibh nec lectus hendrerit lobortis eget mattis ligula. Nam auctor lectus odio, at consequat nisi lobortis sed. Mauris vel nibh mattis, rutrum nisl id, elementum tortor.

    Fusce facilisis purus ac mattis dignissim. Aliquam pellentesque, enim dapibus imperdiet rhoncus, nisl felis mattis augue, ut ultricies mi magna ultrices nulla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris dapibus massa a risus dictum fringilla. Cras aliquet feugiat elit id faucibus. Donec in faucibus purus. Donec laoreet sagittis eros, quis tristique velit. Etiam id nisl vel risus aliquet pretium non sed massa. Aliquam erat volutpat.

    In bibendum at est ac feugiat. Ut fermentum molestie consectetur. Mauris id lectus hendrerit, porta dolor eget, dapibus leo. Sed dictum magna a metus vulputate pretium. Aenean eu ante ac velit blandit gravida dignissim sit amet velit. Suspendisse hendrerit ultrices lorem at dignissim. Sed rhoncus et lorem vel ultrices. Ut felis eros, consequat mollis ipsum scelerisque, tempus cursus augue. Duis quis dignissim felis, at feugiat sapien. Donec luctus ultrices iaculis. Fusce elit arcu, vestibulum et lorem vel, fermentum molestie diam.

    Phasellus nec tortor eros. Nulla facilisis urna mauris, quis suscipit ante laoreet ultricies. Maecenas commodo tortor vitae elit imperdiet fermentum. Proin id sem imperdiet, tincidunt dolor id, semper risus. Nunc lacinia egestas turpis, ut ullamcorper nibh viverra a. Nunc viverra leo metus, id porta diam mollis et. Sed lobortis urna vel est bibendum ornare.

    Nulla laoreet imperdiet consequat. Fusce ornare varius eros vel auctor. Phasellus pretium eget lectus eu volutpat. Nam ut eleifend sem. Duis suscipit interdum turpis, porttitor iaculis velit elementum pharetra. Curabitur eget arcu et nisl laoreet congue. In hendrerit libero justo. Aliquam sit amet consectetur lacus. Integer congue porttitor varius. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce ut nulla rutrum, vehicula nisi sed, laoreet dolor. In ultrices est eget urna euismod, non condimentum dui cursus.

    Donec non nulla at tortor mollis feugiat. Etiam hendrerit risus condimentum leo ornare, vel sodales ipsum lobortis. Vivamus nec lectus leo. Phasellus eget nibh purus. Fusce sodales nisl id urna mollis, vel lobortis velit ultrices. Nunc et est erat. Integer placerat scelerisque elit id convallis. Sed feugiat molestie nunc nec ultrices. Vivamus ultrices eget arcu vel rhoncus. Cras eleifend suscipit dolor, vitae mattis lorem gravida at. Etiam eu tellus ac elit sollicitudin commodo ac sed nisi. Mauris faucibus at urna in porta. Curabitur fringilla, diam non porttitor tempor, neque lacus consequat eros, vel commodo nunc purus eu nisl. In purus mi, auctor a viverra pulvinar, consectetur non lacus. Nullam viverra malesuada gravida. Maecenas scelerisque urna suscipit, pharetra ligula vel, mattis tellus.

    Quisque ligula est, iaculis eget nisi ut, eleifend rutrum purus. Suspendisse magna tellus, auctor ut quam et, mattis semper nunc. Maecenas ullamcorper orci libero, et ullamcorper enim luctus ut. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed eleifend eleifend malesuada. Nunc id porta ante. Sed a quam massa. Nam euismod nulla vitae ante molestie dignissim. Donec semper mauris ac facilisis tristique. Donec convallis est purus, in ultrices lectus feugiat nec. Sed congue nibh orci, eget tempus sem molestie a.

    Aliquam eget placerat sem, sed dictum tortor. Aenean et auctor magna. Aliquam sodales urna non dictum elementum. Curabitur ac pulvinar lacus. Vivamus dapibus turpis turpis, sit amet luctus libero ullamcorper et. Mauris et faucibus ante. Aenean tincidunt hendrerit eros at rhoncus. Suspendisse risus neque, euismod in ipsum sed, commodo euismod nunc. Aliquam fringilla rutrum elit et vulputate. Integer vitae accumsan erat. Nulla scelerisque congue posuere. Aliquam a justo bibendum neque laoreet congue. Vestibulum ut turpis scelerisque, egestas nulla a, auctor nisl. Donec sodales diam non nisi porta, at malesuada tortor luctus. Maecenas pellentesque dolor quis viverra mollis. Praesent eu venenatis ipsum, in eleifend nunc.

    Vivamus semper nunc a lorem hendrerit tristique. Etiam ac convallis sapien. Morbi faucibus, nisi sit amet malesuada sagittis, libero velit congue massa, quis rutrum lacus arcu imperdiet quam. Vestibulum eleifend lectus eget metus sodales, eu tristique erat aliquet. Praesent ornare, enim sit amet vulputate interdum, odio ipsum varius felis, a auctor urna metus in tortor. Sed purus dolor, dapibus id sodales id, lobortis at odio. Morbi ut dui sit amet tortor scelerisque fermentum. Fusce vehicula tempus tortor a convallis. Quisque orci ipsum, dictum quis lacus at, viverra faucibus leo. Maecenas pellentesque pretium odio, et luctus leo fringilla a. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper pharetra dui sit amet volutpat. In dapibus lacus orci, quis luctus arcu congue eu. Vivamus fermentum fringilla arcu, sed convallis lectus mattis ut. Mauris sollicitudin ante cursus justo commodo iaculis.

    Nullam eget lorem nisl. Mauris at tincidunt lacus. Nulla facilisi. Sed pharetra interdum dui, quis condimentum purus rhoncus et. Proin dictum nisl vel massa pulvinar vestibulum. Nullam mi sem, lacinia ut ipsum eget, scelerisque bibendum eros. Duis malesuada turpis vel leo iaculis, eget pretium nunc pulvinar. Integer non dictum nunc.

    Quisque et tortor dictum, dapibus quam sed, semper eros. Proin tristique elementum laoreet. Suspendisse purus odio, ultricies porttitor sollicitudin et, sollicitudin pellentesque magna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer ac elit sit amet ipsum bibendum porta in id orci. Nulla facilisi. Nulla euismod elementum sollicitudin.

    Fusce laoreet arcu sit amet enim accumsan rhoncus. Quisque at purus aliquet, pharetra elit non, sodales ipsum. Curabitur eu scelerisque lorem, in ornare neque. Nulla molestie malesuada tempus. Quisque fringilla ligula at justo rhoncus, at fermentum ante adipiscing. Vivamus nec commodo nulla. Sed et rutrum nisl, dignissim feugiat nunc. Mauris ornare tincidunt sem. Cras tortor augue, lobortis vel mollis at, rutrum eu velit. Cras ligula arcu, aliquam a volutpat nec, lacinia et dolor. Nullam quis ullamcorper magna. Quisque sit amet lectus leo.
    ';
    $text = $lorem;
    $starting_position = rand(0, strlen($text));
    $leading_text = substr($text, $starting_position);
    $text = ucfirst(trim($leading_text)) . ' ' . $text;
    $text = simple_truncate($text, $words);
    return $text;
}

function apply_dummy_filter($text, $words) {
    if (!strlen(trim($text))) {
        return apply_dummy($words);
    }
    return $text;
}

?>
