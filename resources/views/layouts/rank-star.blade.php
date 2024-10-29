<div class="text-gray-700 text-2xl m-1 flex items-center justify-between" style="width:120px">
    <span class="absolute inline-block h-8 text-gray-500" style="width:120px">
        ★★★★★
    </span>
    <span class="relative inline-block h-8" style="width:120px">
    </span>
    <span class="absolute inline-block h-8 overflow-hidden text-orange-300"
        style="width:{{ $review->getAverageRank($world->id) * 24 }}px">
        ★★★★★
    </span>
</div>
