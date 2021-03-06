// AoC.cpp : Defines the entry point for the console application.
//

#include "stdafx.h"


struct Player
{
	unsigned int id;
	unsigned int score;
	std::string toString()
	{
		return "[Player] Id: " + std::to_string(id) + ", Score: " + std::to_string(score);
	}
};

auto g_Players = new CyclicLinkedList<unsigned long long>(0);
auto g_Marbles = new CyclicLinkedList<int>(0);

void PopulatePlayers(const int amount)
{
	for (unsigned int i = 1; i < amount; i++)
	{
		g_Players->insert(0);
	}
}

int main()
{
	const auto playerCount = 471;
	PopulatePlayers(playerCount);

	const auto lastMarble = 7202600;
	for (auto i = 1; i <= lastMarble; i++)
	{
		g_Players->next();

		if (i % 23 != 0)
		{
			g_Marbles->next();
			g_Marbles->insert(i);
			continue;
		}

		g_Players->current->value += i;
		for (auto j = 0; j < 7; j++)
		{
			g_Marbles->prev();
		}

		g_Players->current->value += g_Marbles->current->value;
		g_Marbles->remove();
	}

	unsigned long long best = 0;
	for (auto i = 0; i < playerCount; i++)
	{
		const auto player = g_Players->current->value;
		if (player > best)
		{
			best = g_Players->current->value;
		}
		g_Players->next();
	}

	std::cout << best << std::endl;

    return 0;
}