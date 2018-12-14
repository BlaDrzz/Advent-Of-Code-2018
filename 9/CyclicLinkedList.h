#pragma once

template <typename T>
struct Node
{
	T value;

	Node<T>* next;
	Node<T>* prev;
};

template <typename T>
struct CyclicLinkedList
{
	CyclicLinkedList(T value)
	{
		current = new Node<T>{ value };
		current->next = current;
		current->prev = current;
	}

	Node<T>* current;

	void next()
	{
		current = current->next;
	}

	void prev()
	{
		current = current->prev;
	}

	void insert(T value)
	{
		const auto newNode = new Node<T>{ value };

		newNode->prev = current;
		newNode->next = current->next;

		current->next->prev = newNode;
		current->next = newNode;
		next();
	}

	void remove()
	{
		const auto next = current->next;
		current->prev->next = current->next;
		current->next->prev = current->prev;
		delete current;
		current = next;
	}
};

