#include "stdafx.h"
#include "Day12.h"

Day12::Day12()
{
	const auto input = fio::FileToVec("input");
	_track = new Track(input);
}

Day12::~Day12()
{
	delete _track;
}

void Day12::executePartOne()
{
	_track->run();
}

void Day12::executePartTwo()
{
	// I kinda rewrote part 1 to do part 2 as well :/
}
