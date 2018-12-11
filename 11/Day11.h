#pragma once
#include "AbstractDay.h"

#define GRID_SIZE 299

struct PowerSquare
{
	Tuple<int> pos;
	int powerValue;
	int size;
};

class Day11 : public AbstractDay
{
public:
	Day11(int input);
	virtual ~Day11() = default;

	void executePartOne() override;
	void executePartTwo() override;

private:
	int _fuelCells[GRID_SIZE][GRID_SIZE] = {};

	int calculatePowerLevel(Tuple<int> pos, int serialNumber);
	PowerSquare getBestSquare(int size);
	int getSquareValue(Tuple<int> pos, int size);
};

