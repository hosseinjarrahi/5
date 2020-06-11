<?php

namespace Quizviran\Repositories;

use Quizviran\Models\Room;

class RoomRepo
{
    public static function getWithExams($link)
    {
        return Room::with([
            'exams' => function ($query) {
                $query->latest();
            },
        ])->where('link', $link)->first();
    }

    public static function withUserFindOrFail($room)
    {
        return Room::with('user')->findOrFail($room);
    }

    public static function getFromLink($link)
    {
        return Room::where('link', $link)->firstOrFail();
    }

    public static function withMemberCount($link)
    {
        return Room::where('link', $link)->withCount('members')->firstOrFail();
    }

    public static function create($name, $link, $code)
    {
        return Room::create([
            'name' => $name,
            'link' => $link,
            'user_id' => auth()->id(),
            'code' => $code,
        ]);
    }

    public static function findByLink($link)
    {
        return Room::where('link', $link)->first();
    }

    public static function findByCode($code)
    {
        return Room::where('code', $code)->first();
    }

    public static function withMembersBylink($link)
    {
        return Room::where('link', $link)->with('members')->withCount('members')->firstOrFail();
    }

    public static function findOrFail($id)
    {
        return Room::findOrFail($id);;
    }

    public static function toggleLock($room)
    {
        $room->lock = ! $room->lock;
        $room->save();
    }

    public static function toggleGap($room)
    {
        $room->gapLock = ! $room->gapLock;
        $room->save();
    }

    public static function findOpenedRoomWithCode($code)
    {
        return Room::where('lock', false)->where('code', $code)->first();
    }
}
