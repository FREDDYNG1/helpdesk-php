<?php

class TicketController
{
    private TicketRepository $ticketRepository;

    public function __construct(
        TicketRepository $ticketRepository
    ) {
        $this->ticketRepository = $ticketRepository;
    }

    public function index(): array
    {
        return $this->ticketRepository->findAll();
    }
}
