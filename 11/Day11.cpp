#include "stdafx.h"
#include "Day11.h"
#include "LoadingBar.h"


Day11::Day11(const int input)
{
	for (auto x = 0; x < GRID_SIZE; ++x)
	{
		for (auto y = 0; y < GRID_SIZE; ++y)
		{
			_fuelCells[x][y] = calculatePowerLevel({ x, y }, input);
		}
	}
}

int Day11::calculatePowerLevel(const Tuple<int> pos, const int serialNumber)
{
	const auto id = pos.first + 10;
	return id * (id * pos.second + serialNumber) / 100 % 10 - 5;
}

PowerSquare Day11::getBestSquare(const int size = 3)
{
	auto bestSquare = PowerSquare{ 0, 0, 0, size };

	for (auto x = 0; x < GRID_SIZE - size; ++x)
	{
		for (auto y = 0; y < GRID_SIZE - size; ++y)
		{
			const auto squareValue = getSquareValue(Tuple<int>{ x, y }, size);
			if (squareValue > bestSquare.powerValue)
			{
				bestSquare = { x, y, squareValue, size };
			}
		}
	}

	return bestSquare;
}

int Day11::getSquareValue(const Tuple<int> pos, const int size = 3)
{
	auto value = 0;
	for (auto i = 0; i < size; ++i)
	{
		const auto x = pos.first + i;
		for (auto j = 0; j < size; ++j)
		{
			value += _fuelCells[x][pos.second + j];
		}
	}

	return value;
}

void Day11::executePartOne()
{
#ifdef _WIN32
	system("cls");
#else
	system("clear");
#endif

	std::cout << "Executing 11-1\n";
	const auto bestSquare = getBestSquare();
	std::cout << "Best coordinate: " << bestSquare.pos.first << "," << bestSquare.pos.second << std::endl;
}

void Day11::executePartTwo()
{
	std::cout << "Executing 11-2" << std::endl;
	const auto iterations = 30;
	const auto loadingBar = new LoadingBar(30, 0, iterations, '[', ']', ' ', '#');

	PowerSquare bestSquare = { 0, 0, 0, 0 };
	for (auto size = 0; size < iterations; ++size)
	{
		const auto square = getBestSquare(size);
		if (square.powerValue > bestSquare.powerValue)
		{
			bestSquare = square;
		}
		loadingBar->iterate();
		loadingBar->print();
	}

	delete loadingBar;
	std::cout << std::endl << "Best coordinate: " << bestSquare.pos.first << "," << bestSquare.pos.second << "," << bestSquare.size << std::endl;
}


