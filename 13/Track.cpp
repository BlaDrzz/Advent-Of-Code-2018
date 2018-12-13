#include "stdafx.h"

Track::Track(std::vector<std::string> input)
{
	std::cout << "Constructing track" << std::endl;

	_sizeY = input.size();
	_sizeX = input.front().size();

	for (auto y = 0; y < _sizeY; ++y)
	{
		for (auto x = 0; x < _sizeX; ++x)
		{
			const auto c = input[y][x];
			if (c == ' ') continue;

			_track.insert(TrackPiece{ Int2{ x, y }, placeCartsAndConvertToRail(c, x, y) });
		}
	}
	std::cout << std::endl << "And found: " << _carts.size() << " carts!" << std::endl;
}

Track::~Track()
{
	for (auto cart : _carts)
	{
		delete cart;
	}
}

void Track::run()
{
	while (step()) {}
}

inline bool CompareCartPtr(Cart* left, Cart* right)
{
	return left->position < right->position;
}

bool Track::step()
{
	if (_carts.size() == 1)
	{
		const auto winner = _carts.front();
		std::cout << winner->position << std::endl;
		return false;
	}

	std::sort(_carts.begin(), _carts.end(), CompareCartPtr);
	std::vector<int> markedForDelete;

	for (size_t i = 0; i < _carts.size(); i++)
	{
		const auto cart = _carts[i];
		std::cout << "Moving cart at pos " << cart->position << '\n';

		cart->move();
		cart->setVelocityBasedOnTrackPiece(_track.at(cart->position));

		for (size_t j = 0; j < _carts.size(); j++)
		{
			const auto otherCart = _carts[j];
			if (cart == otherCart) continue;
			if (cart->position == otherCart->position)
			{
				markedForDelete.push_back(j);
				markedForDelete.push_back(i);
			}
		}
	}
	for (auto cart : markedForDelete)
	{
		delete _carts[cart];
		_carts[cart] = nullptr;
	}
	std::vector<Cart*> newCarts;
	for (const auto cart : _carts)
	{
		if (cart != nullptr)
		{
			newCarts.push_back(cart);
		}
	}
	_carts = newCarts;

	//printCarts();
	std::cout << "------------------ step complete -----------------\n";
	return true;
}

char Track::placeCartsAndConvertToRail(const char c, const int x, const int y)
{
	if (c == '<')
	{
		_carts.push_back(new Cart({ { x, y }, { -1, 0 } }));
		return '-';
	}

	if (c == '>')
	{
		_carts.push_back(new Cart({ { x, y }, { 1, 0 } }));
		return '-';
	}

	if (c == '^')
	{
		_carts.push_back(new Cart({ { x, y }, { 0, -1 } }));
		return '|';
	}

	if (c == 'v')
	{
		_carts.push_back(new Cart({ { x, y }, { 0, 1 } }));
		return '|';
	}

	return c;
}

void Track::printTrack()
{
	const auto trackStr = trackToStringVec();
	for (const auto str : trackStr)
	{
		for (const auto c : str)
		{
			std::cout << c;
		}
		std::cout << '\n';
	}
}

std::vector<std::string> Track::trackToStringVec()
{
	std::vector<std::string> res;
	for (auto y = 0; y < _sizeY; ++y)
	{
		std::string str = "";
		for (auto x = 0; x < _sizeX; ++x)
		{
			try
			{
				str += _track[{ x, y }];
			}
			catch (std::out_of_range &ex)
			{
				str += ' ';
			}
		}
		res.push_back(str);
	}
	return res;
}

void Track::printCarts()
{
	auto trackStr = trackToStringVec();
	for (const auto cart : _carts)
	{
		trackStr[cart->position.y][cart->position.x] = 'X';
	}

	for (const auto str : trackStr)
	{
		for (const auto c : str)
		{
			std::cout << c;
		}
		std::cout << '\n';
	}
}
