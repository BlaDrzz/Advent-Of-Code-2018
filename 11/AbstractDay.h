#pragma once
class AbstractDay
{
public:
	AbstractDay() = default;
	virtual ~AbstractDay() = default;

	virtual void executePartOne() = 0;
	virtual void executePartTwo() = 0;
};

