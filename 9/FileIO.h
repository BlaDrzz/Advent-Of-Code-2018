// modified version from https://github.com/BlaDrzz/CppUtility/blob/master/Utils/FileIO.h
#pragma once

#include <string>
#include <vector>
#include <fstream>

using namespace std;

namespace fio
{
	// Read contents of a file and return a string vector
	inline vector<string> FileToVec(const string path)
	{
		vector<string> result;

		ifstream file;
		string line;

		file.open(path);
		while (getline(file, line))
			result.push_back(line);

		file.close();

		return result;
	}
}