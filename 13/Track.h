#pragma once

struct Int2
{
	int x;
	int y;

	Int2(const int xVal = 0, const int yVal = 0)
	{
		x = xVal;
		y = yVal;
	}
	Int2(const Int2 &other)
	{
		x = other.x;
		y = other.y;
	}
	void swap()
	{
		const auto z = x;
		x = y;
		y = z;
	}
	void negate()
	{
		x = -x;
		y = -y;
	}
	friend Int2 operator+(const Int2 &left, const Int2 &right)
	{
		return Int2(left.x + right.x, left.y + right.y);
	}
	friend bool operator<(const Int2 &left, const Int2 &right)
	{
		return std::tie(left.y, left.x) < std::tie(right.y, right.x);
	}
	friend bool operator==(const Int2 &left, const Int2 &right)
	{
		return std::tie(left.x, left.y) == std::tie(right.x, right.y);
	}
};

inline std::ostream& operator<<(std::ostream& os, const Int2& int2)
{
	return os << int2.x << ", " << int2.y;
}

struct Cart
{
	Int2 position;
	Int2 velocity;
	enum class TURN { LEFT, NO, RIGHT };
	TURN turn = TURN::LEFT;

	void setVelocityBasedOnTrackPiece(const char c)
	{
		if (c == '|' || c == '-')
		{
			return;
		}

		if (c == '\\')
		{
			velocity.swap();
		} 
		else if (c == '/')
		{
			velocity.swap();
			velocity.negate();
		} 
		else if (c == '+')
		{
			switch (turn)
			{
			case TURN::LEFT:
				{
					const auto velX(velocity.x);
					velocity.x = velocity.y;
					velocity.y = -velX;
					turn = TURN::NO;
					break;
				}
			case TURN::NO:
				turn = TURN::RIGHT;
				break;
			case TURN::RIGHT:
				{
					const auto velX(velocity.x);
					velocity.x = -velocity.y;
					velocity.y = velX;
					turn = TURN::LEFT;
					break;
				}
			default: break;
			}
		}
	}

	void move()
	{
		position.x += velocity.x;
		position.y += velocity.y;
	}
};

typedef std::pair<Int2, char> TrackPiece;

class Track
{
public:
	Track(std::vector<std::string> input);
	~Track();

	void run();
private:
	int _sizeX, _sizeY;
	std::map<Int2, char> _track;
	std::vector<Cart*> _carts;

	bool step();

	char placeCartsAndConvertToRail(char c, int x, int y);

	void printTrack();
	std::vector<std::string> trackToStringVec();
	void printCarts();
};

