/*
 * LOADING BAR FROM https://github.com/BlaDrzz/CppUtility
 */

#pragma once

#include <string>

using namespace std;

class LoadingBar
{
public:
	// Constructors
	LoadingBar() : LoadingBar(20, 0, 100) {}
	LoadingBar(const int size, const int min, const int max,
		const char leftBound = '[',
		const char rightBound = ']',
		const char empty = '.',
		const char progressed = '#') :
		_min(min),
		_max(max),
		_size(size),
		_progress(min),
		_cLeft(leftBound),
		_cRight(rightBound),
		_cEmpty(empty),
		_cProgress(progressed) {}

	// Destructor
	~LoadingBar();

	// Conver to string
	string toString();

	// Print to console
	void print();

	// Iterate progress
	void iterate() { _progress++; }

	// ostream overload
	friend ostream& operator<<(ostream& os, const LoadingBar& lb);
private:
	// Private functions

	// Calculates the progress
	int calcProgress();

	// Clamps the progress between min and max
	int clampedProgress();

	// Private datamembers
	int _min, _max, _size, _progress, _lastProgress;
	char _cLeft, _cRight, _cEmpty, _cProgress;
};