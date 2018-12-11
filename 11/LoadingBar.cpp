#include "stdafx.h"
#include "LoadingBar.h"


LoadingBar::~LoadingBar()
{
	// Nothing to destroy
}

string LoadingBar::toString()
{
	stringstream ss;

	const auto progressed = calcProgress();

	if (_lastProgress != progressed)

		// Construct message
		ss << _cLeft;
	for (int i = 0; i < progressed; i++)
		ss << _cProgress;
	for (int i = 0; i < _size - progressed; i++)
		ss << _cEmpty;
	ss << _cRight;

	return ss.str();
}

void LoadingBar::print()
{
	if (_lastProgress != calcProgress())
		cout << this->toString() << '\r' << flush;
}

int LoadingBar::calcProgress()
{
	return int(round(double(_size * _progress) / double(_max)));
}

int LoadingBar::clampedProgress()
{
	return _progress > _max ?
		_max :
		_progress < _min ?
		_min :
		_progress;
}

ostream& operator<<(ostream &os, LoadingBar &lb)
{
	os << lb.toString().c_str();
	return os;
}